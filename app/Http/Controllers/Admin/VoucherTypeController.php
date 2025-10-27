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
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Config;
use App\Models\VoucherType;

class VoucherTypeController extends Controller
{

      public function index(Request $request)
        {
            $search = $request->input('search');

            $Vouchers = VoucherType::query()
                ->when($search, function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('desc', 'like', "%{$search}%");
                })
                ->orderBy('name', 'asc')
                ->paginate(config('default_pagination'));
                // dd($clients);
            return view('admin-views.voucher_type.index', compact('Vouchers'));
        }




     public function store(Request $request)
    {
         $request->validate([
            'name' => 'required|max:100',
            'client_message' => 'required',
             'logo_image' => 'required',
             'type' => 'required',
        ]);
        $Voucher = new VoucherType();
        $Voucher->name = $request->name;
       $Voucher->management_id = !empty($request->type)  ? implode(',', $request->type) : null;
        $Voucher->desc = $request->client_message;
        $Voucher->status = "active";

            //  Logo Upload
        if ($request->hasFile('logo_image')) {
            $file = $request->file('logo_image');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;

            $destination = public_path('uploads/Voucher');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $imageName);
            $Voucher->logo = 'uploads/Voucher/' . $imageName; // save path in DB
        }

        $Voucher->save();

        Toastr::success('Voucher added successfully');
        return back();
    }

    public function edit($id)
    {
        $Voucher = VoucherType::where('id', $id)->first();
        $selectedTypes = explode(',', $Voucher->management_id);
        return view('admin-views.voucher_type.edit', compact('Voucher','selectedTypes'));
    }


   public function update(Request $request, $id)
    {
         $request->validate([
            'name' => 'required|max:100',
            'client_message' => 'required',
            'type' => 'required',
        ]);

        $Voucher = VoucherType::findOrFail($id);

        $Voucher->name = $request->name;
        $Voucher->management_id = !empty($request->type)  ? implode(',', $request->type) : null;
        $Voucher->desc = $request->client_message;

            //  Logo Upload
    if ($request->hasFile('logo_image')) {
        if ($Voucher->logo && file_exists(public_path($Voucher->logo))) {
            unlink(public_path($Voucher->logo)); // old delete
        }
        $file = $request->file('logo_image');
        $extension = $file->getClientOriginalExtension();
        $imageName = time() . '_' . uniqid() . '.' . $extension;

        $destination = public_path('uploads/Voucher');
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $imageName);
        $Voucher->logo = 'uploads/Voucher/' . $imageName;
    }

        $Voucher->save();

        Toastr::success('Voucher updated successfully');
        return back();
    }

    public function delete(Request $request, $id)
    {
        $Voucher = VoucherType::findOrFail($id);
          //  Delete Logo
        if ($Voucher->logo && file_exists(public_path($Voucher->logo))) {
            unlink(public_path($Voucher->logo));
        }
        $Voucher->delete();

        Toastr::success(' deleted successfully');
        return back();
    }

    public function status( $id)
    {
        $Voucher = VoucherType::findOrFail($id);
        // dd($Voucher);
        // agar active hai to inactive karo, warna active karo
        $Voucher->status = $Voucher->status === 'active' ? 'inactive' : 'active';
        $Voucher->save();
        Toastr::success('Voucher Status successfully  '.$Voucher->status);
        return back();

    }
}
