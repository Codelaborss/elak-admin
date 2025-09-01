<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\Banner;
use App\Models\Client;
use App\Models\Segment;
use App\Models\FlashSale;
use Illuminate\View\View;
use App\Models\ColorTheme;
use App\Exports\ZoneExport;
use Illuminate\Http\Request;

use App\Models\FlashSaleItem;
use App\Services\ZoneService;
use App\CentralLogics\Helpers;
use Illuminate\Http\JsonResponse;
use App\Models\AccountTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use App\Exports\CollectUserListExport;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\BaseController;
use App\Enums\ExportFileNames\Admin\Zone;
use App\Http\Requests\Admin\ZoneAddRequest;
use Illuminate\Database\Eloquent\Collection;
use App\Exports\CollectCashTransactionExport;
use App\Http\Requests\Admin\ZoneUpdateRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Enums\ViewPaths\Admin\Zone as ZoneViewPath;
use App\Http\Requests\Admin\ZoneModuleUpdateRequest;
use App\Contracts\Repositories\ZoneRepositoryInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Contracts\Repositories\TranslationRepositoryInterface;
use App\Models\AppBanner;
use App\Models\Category;

class ClientSideController extends Controller
{
    public function __construct(
        protected ZoneRepositoryInterface $zoneRepo,
        protected ZoneService $zoneService,
        protected TranslationRepositoryInterface $translationRepo
    ) {}


    public function export_account_transaction(Request $request)
    {
        // $all_users = User::latest()->get();
        $all_users = User::latest()->get();

        // Excel/CSV export
        if ($request->type == 'excel') {
            return Excel::download(new CollectUserListExport($all_users), 'UsersList.xlsx');
        } elseif ($request->type == 'csv') {
            return Excel::download(new CollectUserListExport($all_users), 'UsersList.csv');
        }
    }

    public function index(Request $request)
    {
        $Segment = Segment::all();
        $search = $request->input('search');

        $clients = Client::query()
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('name', 'asc')
            ->paginate(config('default_pagination'));

        // add type_names attribute for each client
        $clients->getCollection()->transform(function ($client) {
            if ($client->type) {
                $ids = explode(',', $client->type);
                $client->type_names = \App\Models\Segment::whereIn('id', $ids)->pluck('name')->toArray();
            } else {
                $client->type_names = [];
            }

            return $client;
        });
        return view('admin-views.client-side.index', compact('clients', 'Segment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:clients,email',
            'password' => 'required|min:6',
            'logo_image' => 'nullable|image',
            'cover_image' => 'nullable|image',
            'type' => 'required|array',   // ensure array
        ]);

        $client = new Client();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->password = bcrypt($request->password);
        $client->type = implode(',', $request->type);

        //  Logo Upload
        if ($request->hasFile('logo_image')) {
            $file = $request->file('logo_image');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;

            $destination = public_path('uploads/clients/logos');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $imageName);
            $client->logo = 'uploads/clients/logos/' . $imageName; // save path in DB
        }

        //  Cover Upload
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;

            $destination = public_path('uploads/clients/covers');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $imageName);
            $client->cover = 'uploads/clients/covers/' . $imageName;
        }

        $client->save();

        Toastr::success('Client added successfully');
        return back();
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        $selectedTypes = $client->type ? explode(',', $client->type) : [];
        $Segment = Segment::all(); // tumhara segment list

        return view('admin-views.client-side.edit', compact('client', 'selectedTypes', 'Segment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:clients,email,' . $id, // ignore current email
            'password' => 'nullable|min:6',
            'logo_image' => 'nullable|image',
            'cover_image' => 'nullable|image',
            'type' => 'required|array',   // ensure array

        ]);

        $client = Client::findOrFail($id);

        $client->name = $request->name;
        $client->email = $request->email;

        if ($request->filled('password')) {
            $client->password = bcrypt($request->password);
        }
        // Save type as comma separated string
        $client->type = implode(',', $request->type);

        //  Logo Upload
        if ($request->hasFile('logo_image')) {
            if ($client->logo && file_exists(public_path($client->logo))) {
                unlink(public_path($client->logo)); // old delete
            }
            $file = $request->file('logo_image');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;

            $destination = public_path('uploads/clients/logos');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $imageName);
            $client->logo = 'uploads/clients/logos/' . $imageName;
        }

        //  Cover Upload
        if ($request->hasFile('cover_image')) {
            if ($client->cover && file_exists(public_path($client->cover))) {
                unlink(public_path($client->cover));
            }
            $file = $request->file('cover_image');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;

            $destination = public_path('uploads/clients/covers');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $imageName);
            $client->cover = 'uploads/clients/covers/' . $imageName;
        }

        $client->save();

        Toastr::success('Client updated successfully');
        return back();
    }

    public function delete(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        //  Delete Logo
        if ($client->logo && file_exists(public_path($client->logo))) {
            unlink(public_path($client->logo));
        }

        //  Delete Cover
        if ($client->cover && file_exists(public_path($client->cover))) {
            unlink(public_path($client->cover));
        }

        //  Delete Avatar/Profile
        if ($client->avatar && file_exists(public_path($client->avatar))) {
            unlink(public_path($client->avatar));
        }

        //  Delete Client Record
        $client->delete();

        Toastr::success('Client deleted successfully with all images');
        return back();
    }

    public function status($id)
    {
        $Client = Client::findOrFail($id);
        // dd($Client);
        // agar active hai to inactive karo, warna active karo
        $Client->status = $Client->status === 'active' ? 'inactive' : 'active';
        $Client->save();
        Toastr::success('Client Status successfully  ' . $Client->status);
        return back();
    }

    public function listclient_user(Request $request)
    {
        $Clients = Client::all();
        $Segment = Segment::all();
        $search = $request->input('search');

        $Users = User::query()
            ->leftJoin('clients', 'users.client_id', '=', 'clients.id')
            ->select('users.*', 'clients.name as client_name', 'clients.type as client_type')
            ->when($search, function ($q) use ($search) {
                $q->where('users.status', 'like', "%{$search}%")
                    ->orWhere('clients.name', 'like', "%{$search}%")
                    ->orWhere('users.id', 'like', "%{$search}%");
            })
            ->orderBy('users.f_name', 'asc')
            ->paginate(config('default_pagination'));

        // Transform users to add segment names based on client type field
        $Users->getCollection()->transform(function ($user) {
            // Initialize type_names as empty array
            $user->type_names = [];

            // Check if client has type field with values (from clients table)
            if (!empty($user->client_type)) {
                // Split comma-separated values and remove any whitespace
                $segmentIds = array_filter(array_map('trim', explode(',', $user->client_type)));

                if (!empty($segmentIds)) {
                    // Get segment names from segments table
                    $user->type_names = \App\Models\Segment::whereIn('id', $segmentIds)
                        ->pluck('name')
                        ->toArray();
                }
            }

            return $user;
        });

        return view('admin-views.client-user.index', compact('Users', 'Segment', 'Clients'));
    }


    public function listclient_store(Request $request)
    {
        $request->validate([
            'segment_type' => 'required|integer',
            'select_client' => 'required|integer',
            'add_record_client' => 'required|integer|min:1|max:10000000',
        ]);
        $count = $request->add_record_client;
        //  transaction start
        DB::beginTransaction();
        try {
            // last ref_id check
            $lastRef = DB::table('users')->max('ref_by');
            $startRef = $lastRef ? $lastRef + 1 : 10000;

            $records = [];
            for ($i = 0; $i < $count; $i++) {
                $records[] = [
                    'segment_id' => $request->segment_type,
                    'client_id' => $request->select_client,
                    'role'       => 'user',
                    'status'       => 0,
                    'ref_by'     => $startRef + $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                if (count($records) === 1000) {
                    DB::table('users')->insert($records);
                    $records = [];
                }
            }
            if (!empty($records)) {
                DB::table('users')->insert($records);
            }

            DB::commit(); //  transaction complete

            Toastr::success("$count Clients added successfully (Ref ID from $startRef)");
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Error: ' . $e->getMessage());
        }

        return back();
    }

    public function getSegments($clientId)
    {
        $Client = Client::where('id', $clientId)->first();
        // dd($Client->type);
        $ids = explode(',', trim($Client->type));
        $segments = Segment::whereIn('id', $ids)->get();
        return response()->json($segments);
    }

    public function filter(Request $request)
    {
        $Clients = Client::all();
        $Segment = Segment::all();

        // saare filter values form se le lo
        $clientId   = $request->input('select_client');
        $segmentId  = $request->input('segment_type');
        $refId      = $request->input('ref_id');
        $status     = $request->input('status');
        $fromDate   = $request->input('from_date');
        $toDate     = $request->input('to_date');
        // $search     = $request->input('search');

        // dd($active);
        $Users = User::query()
            ->leftJoin('clients', 'users.client_id', '=', 'clients.id')
            ->select('users.*', 'clients.name as client_name', 'clients.type as client_type')


            // client filter
            ->when($clientId, function ($q) use ($clientId) {
                $q->where('users.client_id', $clientId);
            })

            // ref_id filter
            ->when($refId, function ($q) use ($refId) {
                $q->where('users.ref_by', $refId);
            })

            // status filter
            // status filter
            ->when(isset($status) && $status !== '', function ($q) use ($status) {
                $q->where('users.status', $status);
            })

            // date range filter
            ->when($fromDate && $toDate, function ($q) use ($fromDate, $toDate) {
                $q->whereBetween('users.created_at', [$fromDate, $toDate]);
            })

            ->orderBy('users.f_name', 'asc')
            ->paginate(config('default_pagination'));

        // add type_names attribute for each user
        $Users->getCollection()->transform(function ($user) {
            if ($user->client_type) {
                $ids = explode(',', $user->client_type);
                $user->type_names = \App\Models\Segment::whereIn('id', $ids)->pluck('name')->toArray();
            } else {
                $user->type_names = [];
            }

            return $user;
        });

        //  dd($Users);
        return view('admin-views.client-user.filter', compact('Users', 'Segment', 'Clients'));
    }

    // banner section
    public function banner(Request $request)
    {
        if ($request->isMethod('post')) {

            //  Validation
            $validated = $request->validate([
                'client_id'      => 'required|max:100',
                'title_name'     => 'required|string|max:255',
                'zone_id'        => 'required|integer',
                'banner_type'    => 'required|string',
                'display_number' => 'required|integer',

                // file image/video
                'image'          => 'required|file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi,mkv|max:20480',

                // optional
                'store_id'       => 'nullable|string',
                'external_link'  => 'nullable|url',
                'category'       => 'nullable|string',
                'voucher'        => 'nullable|string',
                'voucher_type'   => 'nullable|string',
            ]);

            //  Model create
            $Banner = new AppBanner();
            $Banner->app_owner_name = $validated['client_id'];
            $Banner->title          = $validated['title_name'];
            $Banner->type_priority  = $validated['display_number'];
            $Banner->status         = 1;
            $Banner->zone_id        = $validated['zone_id'];
            $Banner->banner_type    = $validated['banner_type'];

            // optional fields
            $Banner->store_id     = $validated['store_id']      ?? null;
            $Banner->voucher_id   = $validated['voucher']       ?? null;
            $Banner->category_id  = $validated['category']      ?? null;
            $Banner->voucher_type = $validated['voucher_type']  ?? null;
            $Banner->external_lnk = $validated['external_link'] ?? null;

            //  File Upload (image OR video)
            if ($request->hasFile('image')) {
                $file      = $request->file('image');
                $extension = strtolower($file->getClientOriginalExtension());
                $fileName  = time() . '_' . uniqid() . '.' . $extension;

                $imageExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $videoExt = ['mp4', 'mov', 'avi', 'mkv'];

                if (in_array($extension, $imageExt)) {
                    $path = 'uploads/Banner/images/';
                    $Banner->image_or_video = 'image';
                } elseif (in_array($extension, $videoExt)) {
                    $path = 'uploads/Banner/videos/';
                    $Banner->image_or_video = 'video';
                } else {
                    return back()->withErrors(['image' => 'Invalid file type.']);
                }

                $destination = public_path($path);
                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }

                $file->move($destination, $fileName);
                $Banner->image_or_video = $path . $fileName;
            }

            //  Save
            $Banner->save();

            Toastr::success('Banner added successfully');
            return back();
        }

        // Agar GET ya koi aur request hai

        $Banners = AppBanner::paginate(10);
          $zones = $this->zoneRepo->getList();
            $clients = Client::all();
            $category = Category::all();
        return view("admin-views.client-user.banner", compact('Banners','zones','clients','category'));
    }

    public function edit_banner($id)
    {
        $Banner = AppBanner::findOrFail($id);

        return view('admin-views.client-user.banner_edit', compact('Banner'));
    }
    public function update_banner(Request $request, $id)
    {
        // Validation
        $validated = $request->validate([
            'client_id'      => 'required|max:100',
            'title_name'     => 'required|string|max:255',
            'zone_id'        => 'required|integer',
            'banner_type'    => 'required|string',
            'display_number' => 'required|integer',

            // file image/video
            'image'          => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi,mkv|max:20480',

            // optional
            'store_id'       => 'nullable|string',
            'external_link'  => 'nullable|url',
            'category'       => 'nullable|string',
            'voucher'        => 'nullable|string',
            'voucher_type'   => 'nullable|string',
        ]);

        // Banner find
        $Banner = AppBanner::findOrFail($id);
        $Banner->app_owner_name = $validated['client_id'];
        $Banner->title          = $validated['title_name'];
        $Banner->type_priority  = $validated['display_number'];
        $Banner->zone_id        = $validated['zone_id'];
        $Banner->banner_type    = $validated['banner_type'];

        // optional fields
        $Banner->store_id      = $validated['store_id'] ?? null;
        $Banner->voucher_id    = $validated['voucher'] ?? null;
        $Banner->category_id   = $validated['category'] ?? null;
        $Banner->voucher_type  = $validated['voucher_type'] ?? null;
        $Banner->external_lnk  = $validated['external_link'] ?? null;

        // File Upload (image OR video)
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = strtolower($file->getClientOriginalExtension());
            $fileName = time() . '_' . uniqid() . '.' . $extension;

            $imageExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $videoExt = ['mp4', 'mov', 'avi', 'mkv'];

            if (in_array($extension, $imageExt)) {
                $path = 'uploads/Banner/images/';
            } elseif (in_array($extension, $videoExt)) {
                $path = 'uploads/Banner/videos/';
            } else {
                return back()->withErrors(['image' => 'Invalid file type.']);
            }

            $destination = public_path($path);
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            // 🗑 Purana file delete karo agar exist karta ho
            if (!empty($Banner->image_or_video) && file_exists(public_path($Banner->image_or_video))) {
                unlink(public_path($Banner->image_or_video));
            }

            // Naya file save karo
            $file->move($destination, $fileName);
            $Banner->image_or_video = $path . $fileName;
        }

        // Save
        $Banner->save();

        // Success Message
        Toastr::success('Banner updated successfully');
        return back();
    }


    public function delete_banner(Request $request, $id)
    {
        $Banner = AppBanner::findOrFail($id);
        //  Delete Logo
        if ($Banner->image_or_video && file_exists(public_path($Banner->image_or_video))) {
            unlink(public_path($Banner->image_or_video));
        }
        //  Delete Client Record
        $Banner->delete();

        Toastr::success('Client deleted successfully with all images');
        return back();
    }

    public function status_banner($id)
    {
        $Banner = AppBanner::findOrFail($id);
        // dd($Client);
        // agar active hai to inactive karo, warna active karo
        $Banner->status = $Banner->status === '1' ? '0' : '1';
        $Banner->save();
        Toastr::success('Banner Status successfully  ' . $Banner->status);
        return back();
    }


    public function color_theme(Request $request)
    {
        if ($request->isMethod('post')) {
            // dd($request->all());
            $request->validate([
                'color_name' => 'required|max:100',
                'color_code' => 'required',
                'gradient_option' => 'required',
                'color_type' => 'required',
            ]);

            $Banner = new ColorTheme();
            $Banner->color_name = $request->color_name;
            $Banner->color_code = $request->color_code;
            $Banner->color_gradient	 =  $request->gradient_option;
            $Banner->color_type =  $request->color_type;
            $Banner->save();

            Toastr::success('Color Theme added successfully');
            return back();
        }

        $Banners = ColorTheme::paginate(10);

        return view("admin-views.client-user.colortheme", compact('Banners'));
    }

    public function edit_color_theme($id)
    {
        $ColorTheme = ColorTheme::findOrFail($id);

        return view('admin-views.client-user.colortheme_edit', compact('ColorTheme'));
    }
    public function update_color_theme(Request $request, $id)
    {
        //  Validation
          $request->validate([
                'color_name' => 'required|max:100',
                'color_code' => 'required',
                'gradient_option' => 'required',
                'color_type' => 'required',
            ]);

            if($request->gradient_option == "1"){

                $gra = 1 ;
            }else{
                 $gra = 0;
            }
        //  Client/Banner ko find karo
        $ColorTheme = ColorTheme::findOrFail($id);
        //  Update fields
        $ColorTheme->color_name = $request->color_name;
        $ColorTheme->color_code = $request->color_code;
        $ColorTheme->color_gradient	 = $gra;
        $ColorTheme->color_type =  $request->color_type;
        //  Save ColorTheme
        $ColorTheme->save();

        //  Success Message
        Toastr::success('Color Theme updated successfully');
        return back();
    }


    public function delete_color_theme(Request $request, $id)
    {
         ColorTheme::findOrFail($id);

        Toastr::success('Color Theme deleted successfully ');
        return back();
    }

    public function status_color_theme($id)
    {
        $ColorTheme = ColorTheme::findOrFail($id);
        // dd($Client);
        // agar active hai to inactive karo, warna active karo
        $ColorTheme->status = $ColorTheme->status === '1' ? '0' : '1';
        $ColorTheme->save();
        Toastr::success('Color Theme Status successfully  ' . $ColorTheme->status);
        return back();
    }
}
