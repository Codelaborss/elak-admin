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
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Config;

class workmanagementController extends Controller
{

      public function list(Request $request)
        {
            $search = $request->input('search');

          $UsageTermManagement = WorkManagement::query()
            ->leftJoin('voucher_types', 'work_management.voucher_id', '=', 'voucher_types.id')
            ->when($search, function ($q) use ($search) {
                $q->where('work_management.guid_title', 'like', "%{$search}%")
                ->orWhere('voucher_types.name', 'like', "%{$search}%");
            })
            ->orderBy('work_management.guid_title', 'asc')
            ->select('work_management.*', 'voucher_types.name as voucher_name')
            ->paginate(config('default_pagination'));
            // dd($UsageTermManagement);
            return view('admin-views.work_management.index', compact('UsageTermManagement'));
        }

      public function index(Request $request)
        {
            $search = $request->input('search');

             $vouchers = VoucherType::get();
            // dd($vouchers);
            $ManagementType = WorkManagement::query()
                ->when($search, function ($q) use ($search) {
                    $q->where('guid_title', 'like', "%{$search}%");
                })
                ->orderBy('guid_title', 'asc')
                ->paginate(config('default_pagination'));
            return view('admin-views.work_management.add', compact('ManagementType','vouchers'));
        }


    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'voucher_type'          => 'required|max:100',
            'guide_title'          => 'required',
            'purchase_process'    => 'required|array',
            'payment_confirmation'     => 'required|array',
            'voucher_delivery'     => 'required|array',
            'redemption_process'  => 'required|array',
            'account_management'  => 'required|array',
        ]);

        $ManagementType = new WorkManagement();
        $ManagementType->voucher_id         = $request->voucher_type;
        $ManagementType->guid_title         = $request->guide_title;
        $ManagementType->purchase_process   = json_encode($request->purchase_process);
        $ManagementType->payment_confirm    = json_encode($request->payment_confirmation);
        $ManagementType->voucher_deliver    = json_encode($request->voucher_delivery);
        $ManagementType->redemption_process = json_encode($request->redemption_process);
        $ManagementType->account_management = json_encode($request->account_management);
        $ManagementType->save();

        Toastr::success('Works Guide added successfully');
        return back();
    }


    public function edit($id)
    {
           $vouchers = VoucherType::get();
        $ManagementType = WorkManagement::where('id', $id)->first();
        // dd($ManagementType);
        return view('admin-views.work_management.edit', compact('ManagementType','vouchers'));
    }

    public function update(Request $request, $id)
    {
        $termType = $request->term_type;

            //  Validation
            $request->validate([
            'voucher_type'          => 'required|max:100',
            'guide_title'          => 'required',
            'purchase_process'    => 'required|array',
            'payment_confirmation'     => 'required|array',
            'voucher_delivery'     => 'required|array',
            'redemption_process'  => 'required|array',
            'account_management'  => 'required|array',
        ]);

            //  Record find and update
            $ManagementType = WorkManagement::findOrFail($id);
            $ManagementType->voucher_id         = $request->voucher_type;
            $ManagementType->guid_title         = $request->guide_title;
            $ManagementType->purchase_process   = json_encode($request->purchase_process);
            $ManagementType->payment_confirm    = json_encode($request->payment_confirmation);
            $ManagementType->voucher_deliver    = json_encode($request->voucher_delivery);
            $ManagementType->redemption_process = json_encode($request->redemption_process);
            $ManagementType->account_management = json_encode($request->account_management);
            $ManagementType->save();

            Toastr::success('Work Management updated successfully');
            return back();
    }


    public function delete(Request $request, $id)
    {
        $ManagementType = WorkManagement::findOrFail($id);

        $ManagementType->delete();

        Toastr::success('Work Management deleted successfully');
        return back();
    }

    public function status( $id)
    {
        $ManagementType = WorkManagement::findOrFail($id);
        // dd($ManagementType);
        // agar active hai to inactive karo, warna active karo
        $ManagementType->status = $ManagementType->status === 'active' ? 'inactive' : 'active';
        $ManagementType->save();
        Toastr::success('Work Management Status successfully  '.$ManagementType->status);
        return back();

    }
}
