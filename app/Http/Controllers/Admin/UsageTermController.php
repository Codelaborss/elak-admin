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
use App\Models\UsageTermManagement;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Config;

class UsageTermController extends Controller
{

      public function list(Request $request)
        {
            $search = $request->input('search');

            $UsageTermManagement = UsageTermManagement::query()
                ->when($search, function ($q) use ($search) {
                    $q->where('term_title', 'like', "%{$search}%");
                })
                ->orderBy('term_title', 'asc')
                ->paginate(config('default_pagination'));
            return view('admin-views.usage_term.index', compact('UsageTermManagement'));
        }

      public function index(Request $request)
        {
            $search = $request->input('search');

            $ManagementType = UsageTermManagement::query()
                ->when($search, function ($q) use ($search) {
                    $q->where('term_title', 'like', "%{$search}%");
                })
                ->orderBy('term_title', 'asc')
                ->paginate(config('default_pagination'));
            return view('admin-views.usage_term.add', compact('ManagementType'));
        }


        public function store(Request $request)
    {
        $termType = $request->term_type;


        if ($termType == "informational") {
            // Validation
            $request->validate([
                'term_type' => 'required|max:100',
                'term_title' => 'required',
                'voucher_type' => 'required',
                'desc' => 'required',
                'mesage' => 'required',
                'when_to_display' => 'required',
            ]);

            $ManagementType = new UsageTermManagement();
            $ManagementType->term_type = $request->term_type;
            $ManagementType->term_title = $request->term_title;
            $ManagementType->voucher_type = json_encode($request->voucher_type);
            $ManagementType->term_dec = $request->desc;
            $ManagementType->customer_message = $request->mesage;
            $ManagementType->display_title = $request->when_to_display;
            $ManagementType->status = "active";
            $ManagementType->save();

            Toastr::success('Usages Term and Condition added successfully');
            return back();

        } else {
            // Validation
            $request->validate([
                'term_type' => 'required|max:100',
                'term_title' => 'required',
                'desc' => 'required',
                'days' => 'required',
                'min_purchase_amount' => 'required',
                'condition_is_not_met' => 'required',
                'condition_not_met' => 'required',
            ]);

            $ManagementType = new UsageTermManagement();
            $ManagementType->term_type = $request->term_type;
            $ManagementType->term_title = $request->term_title;
            $ManagementType->voucher_type = json_encode($request->voucher_type); //
            $ManagementType->term_dec = $request->desc;
            $ManagementType->days = json_encode($request->days); //
            $ManagementType->min_purchase_account = $request->min_purchase_amount;
            $ManagementType->condition_is_not_met = $request->condition_is_not_met;
            $ManagementType->message_when_condition_not_meet = $request->condition_not_met;
            $ManagementType->status = "active";
            $ManagementType->save();

            Toastr::success('Usages Term and Condition added successfully');
            return back();
        }
    }


    public function edit($id)
    {
        $ManagementType = UsageTermManagement::where('id', $id)->first();
        return view('admin-views.usage_term.edit', compact('ManagementType'));
    }

    public function update(Request $request, $id)
    {
        $termType = $request->term_type;

        if ($termType == "informational") {
            //  Validation
            $request->validate([
                'term_type' => 'required|max:100',
                'term_title' => 'required',
                'voucher_type' => 'required',
                'desc' => 'required',
                'mesage' => 'required',
                'when_to_display' => 'required',
            ]);

            //  Record find and update
            $ManagementType = UsageTermManagement::findOrFail($id);
            $ManagementType->term_type = $request->term_type;
            $ManagementType->term_title = $request->term_title;
            $ManagementType->voucher_type = json_encode($request->voucher_type);
            $ManagementType->term_dec = $request->desc;
            $ManagementType->customer_message = $request->mesage;
            $ManagementType->display_title = $request->when_to_display;
            $ManagementType->save();

            Toastr::success('Usages Term and Condition updated successfully');
            return back();

        } else {
            //  Validation
            $request->validate([
                'term_type' => 'required|max:100',
                'term_title' => 'required',
                'desc' => 'required',
                'days' => 'required',
                'min_purchase_amount' => 'required',
                'condition_is_not_met' => 'required',
                'condition_not_met' => 'required',
            ]);

            //  Record find and update
            $ManagementType = UsageTermManagement::findOrFail($id);
            $ManagementType->term_type = $request->term_type;
            $ManagementType->term_title = $request->term_title;
            $ManagementType->voucher_type = json_encode($request->voucher_type); //
            $ManagementType->term_dec = $request->desc;
            $ManagementType->days = json_encode($request->days); //
            $ManagementType->min_purchase_account = $request->min_purchase_amount;
            $ManagementType->condition_is_not_met = $request->condition_is_not_met;
            $ManagementType->message_when_condition_not_meet = $request->condition_not_met;
            $ManagementType->save();

            Toastr::success('Usages Term and Condition updated successfully');
            return back();
        }
    }


    public function delete(Request $request, $id)
    {
        $ManagementType = UsageTermManagement::findOrFail($id);
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
        $ManagementType = UsageTermManagement::findOrFail($id);
        // dd($ManagementType);
        // agar active hai to inactive karo, warna active karo
        $ManagementType->status = $ManagementType->status === 'active' ? 'inactive' : 'active';
        $ManagementType->save();
        Toastr::success('Usages Term and Condition Status successfully  '.$ManagementType->status);
        return back();

    }
}
