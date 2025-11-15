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
use App\Models\HolidayOccasion;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Config;

class VoucherSettingController extends Controller
{

       public function list(Request $request)
        {
            $search = $request->input('search');

             $HolidayandOccasion = HolidayOccasion::get();
             $GeneralRestriction = GeneralRestriction::get();

            $HolidayOccasion = HolidayOccasion::query()
                ->when($search, function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orderBy('name', 'asc')
                ->paginate(config('default_pagination'));

            return view('admin-views.voucher_setting.index', compact('HolidayOccasion' ,'HolidayandOccasion','GeneralRestriction'));
        }


      public function index(Request $request)
        {
            $search = $request->input('search');

            $HolidayOccasion = HolidayOccasion::query()
                ->when($search, function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orderBy('name', 'asc')
                ->paginate(config('default_pagination'));
            return view('admin-views.voucher_setting.add', compact('HolidayOccasion','vouchers'));
        }


    public function store(Request $request)
    {
        // Validation
        // dd($request->all());
        $request->validate([
            'name'          => 'required|max:100',
        ]);

        $HolidayOccasion = new HolidayOccasion();
        $HolidayOccasion->name         = $request->name;
        $HolidayOccasion->save();

        Toastr::success('Works Guide added successfully');
        return back();
    }


    public function edit($id)
    {
        $HolidayandOccasion = HolidayOccasion::where('id', $id)->first();

        // dd($sections);
        return view('admin-views.voucher_setting.edit', compact('HolidayandOccasion'));
    }

    public function update(Request $request, $id)
    {
        $termType = $request->term_type;

            //  Validation
            $request->validate([
            'name'          => 'required|max:100',
        ]);

            //  Record find and update
            $HolidayOccasion = HolidayOccasion::findOrFail($id);
            $HolidayOccasion->name         = $request->name;
            $HolidayOccasion->save();

            Toastr::success('Work Management updated successfully');
            return back();
    }


    public function delete(Request $request, $id)
    {
        $HolidayOccasion = HolidayOccasion::findOrFail($id);

        $HolidayOccasion->delete();

        Toastr::success('Work Management deleted successfully');
        return back();
    }

    public function status( $id)
    {
        $HolidayOccasion = HolidayOccasion::findOrFail($id);
        // dd($HolidayOccasion);
        // agar active hai to inactive karo, warna active karo
        $HolidayOccasion->status = $HolidayOccasion->status === 'active' ? 'inactive' : 'active';
        $HolidayOccasion->save();
        Toastr::success('Work Management Status successfully  '.$HolidayOccasion->status);
        return back();

    }
}
