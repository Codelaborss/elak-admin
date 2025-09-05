<?php
namespace App\Http\Controllers\Admin;

use DateTime;
use App\Models\Item;
use App\Models\Client;
use App\Models\Segment;
use App\Models\FlashSale;
use App\Models\VoucherType;
use Illuminate\Http\Request;
use App\Models\FlashSaleItem;
use App\CentralLogics\Helpers;
use App\Models\ManagementType;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Config;

class UsageTermController extends Controller
{

      public function index(Request $request)
        {
            $search = $request->input('search');

            $ManagementType = ManagementType::query()
                ->when($search, function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orderBy('name', 'asc')
                ->paginate(config('default_pagination'));
            return view('admin-views.usage_term.add', compact('ManagementType'));
        }


     public function store(Request $request)
    {
         $request->validate([
            'name' => 'required|max:100',
            'client_message' => 'required',
             'logo_image' => 'required',
        ]);
        $ManagementType = new ManagementType();
        $ManagementType->name = $request->name;
        $ManagementType->des = $request->client_message;
        $ManagementType->status = "active";

            //  Logo Upload
        if ($request->hasFile('logo_image')) {
            $file = $request->file('logo_image');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;

            $destination = public_path('uploads/usage_term');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $imageName);
            $ManagementType->logo = 'uploads/usage_term/' . $imageName; // save path in DB
        }

        $ManagementType->save();

        Toastr::success('Usages Term and Condition added successfully');
        return back();
    }

    public function edit($id)
    {
        $ManagementType = ManagementType::where('id', $id)->first();
        return view('admin-views.usage_term.edit', compact('ManagementType'));
    }

   public function update(Request $request, $id)
    {
         $request->validate([
            'name' => 'required|max:100',
            'client_message' => 'required',
        ]);

        $ManagementType = ManagementType::findOrFail($id);

        $ManagementType->name = $request->name;
        $ManagementType->des = $request->client_message;

            //  Logo Upload
    if ($request->hasFile('logo_image')) {
        if ($ManagementType->logo && file_exists(public_path($ManagementType->logo))) {
            unlink(public_path($ManagementType->logo)); // old delete
        }
        $file = $request->file('logo_image');
        $extension = $file->getClientOriginalExtension();
        $imageName = time() . '_' . uniqid() . '.' . $extension;

        $destination = public_path('uploads/usage_term');
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $imageName);
        $ManagementType->logo = 'uploads/usage_term/' . $imageName;
    }

        $ManagementType->save();

        Toastr::success('Usages Term and Condition updated successfully');
        return back();
    }

    public function delete(Request $request, $id)
    {
        $ManagementType = ManagementType::findOrFail($id);
          //  Delete Logo
        if ($ManagementType->logo && file_exists(public_path($ManagementType->logo))) {
            unlink(public_path($ManagementType->logo));
        }
        $ManagementType->delete();

        Toastr::success('Usages Term and Condition deleted successfully');
        return back();
    }

    public function status( $id)
    {
        $ManagementType = ManagementType::findOrFail($id);
        // dd($ManagementType);
        // agar active hai to inactive karo, warna active karo
        $ManagementType->status = $ManagementType->status === 'active' ? 'inactive' : 'active';
        $ManagementType->save();
        Toastr::success('Usages Term and Condition Status successfully  '.$ManagementType->status);
        return back();

    }
}
