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
                    $q->where('baseinfor_condition_title', 'like', "%{$search}%");
                })
                ->orderBy('baseinfor_condition_title', 'asc')
                ->paginate(config('default_pagination'));
            return view('admin-views.usage_term.index', compact('UsageTermManagement'));
        }

      public function index(Request $request)
        {
            $search = $request->input('search');

            $ManagementType = UsageTermManagement::query()
                ->when($search, function ($q) use ($search) {
                    $q->where('baseinfor_condition_title', 'like', "%{$search}%");
                })
                ->orderBy('baseinfor_condition_title', 'asc')
                ->paginate(config('default_pagination'));
            return view('admin-views.usage_term.add', compact('ManagementType'));
        }


       public function store(Request $request)
    {
        $validated = $request->validate([
            "baseinfor_condition_title" => "nullable|string",
            "baseinfor_description" => "nullable|string",
            "timeandday_config_days" => "nullable|array",
            "timeandday_config_time_range_from" => "nullable|string",
            "timeandday_config_time_range_to" => "nullable|string",
            "timeandday_config_valid_from_date" => "nullable|string",
            "timeandday_config_valid_until_date" => "nullable|string",
            "holiday_occasions_holiday_restrictions" => "nullable|array",
            "holiday_occasions_customer_blackout_dates" => "nullable|string",
            "holiday_occasions_special_occasions" => "nullable|array",
            "usage_limits_limit_per_user" => "nullable|string",
            "usage_limits_period" => "nullable|string",
            "usage_limits_min_purch_account" => "nullable|string",
            "usage_limits_max_discount_amount" => "nullable|string",
            "usage_limits_advance_booking_required" => "nullable|string",
            "usage_limits_group_size_required" => "nullable|string",
            "location_availability_venue_types" => "nullable|array",
            "location_availability_specific_branch" => "nullable|string",
            "location_availability_city" => "nullable|string",
            "location_availability_delivery_radius" => "nullable|string",
            "customer_membership_customer_type" => "nullable|string",
            "customer_membership_age_restriction" => "nullable|string",
            "customer_membership_min_membership_radius" => "nullable|string",
            "restriction_polices_restriction_type" => "nullable|array",
            "restriction_polices_cancellation_policy" => "nullable|string",
            "restriction_polices_excluded_product" => "nullable|string",
            "restriction_polices_surchange_account" => "nullable|string",
            "restriction_polices_surchange_apple" => "nullable|string",
            "status" => "nullable|string",
        ]);

        // Insert record
         UsageTermManagement::create($validated);

          Toastr::success('Usages Term and Condition Created successfully');
            return back();
    }




    public function edit($id)
    {
        $ManagementType = UsageTermManagement::where('id', $id)->first();
        return view('admin-views.usage_term.edit', compact('ManagementType'));
    }

    public function update(Request $request, $id)
    {
           $validated = $request->validate([
                "baseinfor_condition_title" => "nullable|string",
                "baseinfor_description" => "nullable|string",
                "timeandday_config_days" => "nullable|array",
                "timeandday_config_time_range_from" => "nullable|string",
                "timeandday_config_time_range_to" => "nullable|string",
                "timeandday_config_valid_from_date" => "nullable|string",
                "timeandday_config_valid_until_date" => "nullable|string",
                "holiday_occasions_holiday_restrictions" => "nullable|array",
                "holiday_occasions_customer_blackout_dates" => "nullable|string",
                "holiday_occasions_special_occasions" => "nullable|array",
                "usage_limits_limit_per_user" => "nullable|string",
                "usage_limits_period" => "nullable|string",
                "usage_limits_min_purch_account" => "nullable|string",
                "usage_limits_max_discount_amount" => "nullable|string",
                "usage_limits_advance_booking_required" => "nullable|string",
                "usage_limits_group_size_required" => "nullable|string",
                "location_availability_venue_types" => "nullable|array",
                "location_availability_specific_branch" => "nullable|string",
                "location_availability_city" => "nullable|string",
                "location_availability_delivery_radius" => "nullable|string",
                "customer_membership_customer_type" => "nullable|string",
                "customer_membership_age_restriction" => "nullable|string",
                "customer_membership_min_membership_radius" => "nullable|string",
                "restriction_polices_restriction_type" => "nullable|array",
                "restriction_polices_cancellation_policy" => "nullable|string",
                "restriction_polices_excluded_product" => "nullable|string",
                "restriction_polices_surchange_account" => "nullable|string",
                "restriction_polices_surchange_apple" => "nullable|string",
                "status" => "nullable|string",
            ]);
            //  Record find and update
             UsageTermManagement::update($validated);
            Toastr::success('Usages Term and Condition updated successfully');
            return back();


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
