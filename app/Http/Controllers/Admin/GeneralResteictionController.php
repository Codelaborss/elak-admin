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
use App\Models\WorkManagement;
use App\Http\Controllers\Controller;
use App\Models\GeneralRestriction;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Config;

class GeneralResteictionController extends Controller
{

   public function list(Request $request)
    {
        $search = $request->input('search');

        $GeneralRestriction = GeneralRestriction::query()
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name', 'asc')
            ->paginate(config('default_pagination'));

        return view('admin-views.general_restriction.index', compact('GeneralRestriction'));
    }


      public function index(Request $request)
        {
            $search = $request->input('search');

             $vouchers = VoucherType::get();
            // dd($vouchers);
            $ManagementType = GeneralRestriction::query()
                ->when($search, function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orderBy('name', 'asc')
                ->paginate(config('default_pagination'));
            return view('admin-views.general_restriction.add', compact('ManagementType','vouchers'));
        }


    public function store(Request $request)
    {
        // Validation
        // dd($request->all());
        $request->validate([
            'name'          => 'required|max:100',
        ]);

        $ManagementType = new GeneralRestriction();
        $ManagementType->name         = $request->name;
        $ManagementType->save();

        Toastr::success('Works Guide added successfully');
        return back();
    }


    public function edit($id)
    {
        $GeneralRestriction = GeneralRestriction::where('id', $id)->first();


        // dd($sections);
        return view('admin-views.general_restriction.edit', compact('GeneralRestriction'));
    }

    public function update(Request $request, $id)
    {
        $termType = $request->term_type;

            //  Validation
            $request->validate([
            'name'          => 'required|max:100',
        ]);

            //  Record find and update
            $ManagementType = GeneralRestriction::findOrFail($id);
            $ManagementType->name         = $request->name;
            $ManagementType->save();

            Toastr::success('General Restriction updated successfully');
            return back();
    }


    public function delete(Request $request, $id)
    {
        $ManagementType = GeneralRestriction::findOrFail($id);

        $ManagementType->delete();

        Toastr::success('General Restriction deleted successfully');
        return back();
    }

    public function status( $id)
    {
        $ManagementType = GeneralRestriction::findOrFail($id);
        // dd($ManagementType);
        // agar active hai to inactive karo, warna active karo
        $ManagementType->status = $ManagementType->status === 'active' ? 'inactive' : 'active';
        $ManagementType->save();
        Toastr::success('General Restriction Status successfully  '.$ManagementType->status);
        return back();

    }
}
