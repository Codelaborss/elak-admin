<?php
namespace App\Http\Controllers\Admin;

use DateTime;
use App\Models\Item;
use App\Models\Client;
use App\Models\Segment;
use App\Models\FlashSale;
use Illuminate\Http\Request;
use App\Models\FlashSaleItem;
use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\DeliveryOption;
use App\Models\GiftOccasions;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Config;
use App\Models\VoucherType;

class DeliveryOptionController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $DeliveryOption = DeliveryOption::query()
            ->when($search, function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->orderBy('title', 'asc')
            ->paginate(config('default_pagination'));
            // dd($clients);
        return view('admin-views.delivery_options.index', compact('DeliveryOption'));
    }

     public function store(Request $request)
    {
         $request->validate([
            'title' => 'required|max:100',
            'des' => 'required|max:1000',
             'icon' => 'required',
        ]);
        $DeliveryOption = new DeliveryOption();
        $DeliveryOption->title = $request->title;
        $DeliveryOption->des = $request->des;
        $DeliveryOption->status = "active";

            //  Logo Upload
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;

            $destination = public_path('uploads/DeliveryOption');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $imageName);
            $DeliveryOption->icon = 'uploads/DeliveryOption/' . $imageName; // save path in DB
        }

        $DeliveryOption->save();

        Toastr::success('Delivery Option added successfully');
        return back();
    }

    public function edit($id)
    {
        $DeliveryOption = DeliveryOption::where('id', $id)->first();

        return view('admin-views.delivery_options.edit', compact('DeliveryOption'));
    }


   public function update(Request $request, $id)
    {
         $request->validate([
            'title' => 'required|max:100',
            'des' => 'required|max:1000',
        ]);

        $DeliveryOption = DeliveryOption::findOrFail($id);

        $DeliveryOption->title = $request->title;
        $DeliveryOption->des = $request->des;
            //  icon Upload
    if ($request->hasFile('icon')) {
        if ($DeliveryOption->icon && file_exists(public_path($DeliveryOption->icon))) {
            unlink(public_path($DeliveryOption->icon)); // old delete
        }
        $file = $request->file('icon');
        $extension = $file->getClientOriginalExtension();
        $imageName = time() . '_' . uniqid() . '.' . $extension;

        $destination = public_path('uploads/DeliveryOption');
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $imageName);
        $DeliveryOption->icon = 'uploads/DeliveryOption/' . $imageName;
    }

        $DeliveryOption->save();

        Toastr::success('Delivery Option updated successfully');
        return back();
    }

    public function delete(Request $request, $id)
    {
        $DeliveryOption = DeliveryOption::findOrFail($id);
          //  Delete Logo
        if ($DeliveryOption->icon && file_exists(public_path($DeliveryOption->icon))) {
            unlink(public_path($DeliveryOption->icon));
        }
        $DeliveryOption->delete();

        Toastr::success(' deleted successfully');
        return back();
    }

    public function status( $id)
    {
        $DeliveryOption = DeliveryOption::findOrFail($id);
        // dd($Voucher);
        // agar active hai to inactive karo, warna active karo
        $DeliveryOption->status = $DeliveryOption->status === 'active' ? 'inactive' : 'active';
        $DeliveryOption->save();
        Toastr::success('Delivery Option Status successfully  '.$DeliveryOption->status);
        return back();

    }
}
