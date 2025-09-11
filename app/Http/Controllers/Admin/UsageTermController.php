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
            "baseinfor_condition_title" => "required|string",
            "baseinfor_description" => "required|string",
            "timeandday_config_days" => "required|array",
            "timeandday_config_time_range_from" => "required|string",
            "timeandday_config_time_range_to" => "required|string",
            "timeandday_config_valid_from_date" => "required|string",
            "timeandday_config_valid_until_date" => "required|string",
            "holiday_occasions_holiday_restrictions" => "required|array",
            "holiday_occasions_customer_blackout_dates" => "required|string",
            "holiday_occasions_special_occasions" => "required|array",
            "usage_limits_limit_per_user" => "required|string",
            "usage_limits_period" => "required|string",
            "usage_limits_min_purch_account" => "required|string",
            "usage_limits_max_discount_amount" => "required|string",
            "usage_limits_advance_booking_required" => "required|string",
            "usage_limits_group_size_required" => "required|string",
            "location_availability_venue_types" => "required|array",
            "location_availability_specific_branch" => "required|string",
            "location_availability_city" => "required|string",
            "location_availability_delivery_radius" => "required|string",
            "customer_membership_customer_type" => "required|string",
            "customer_membership_age_restriction" => "required|string",
            "customer_membership_min_membership_radius" => "required|string",
            "restriction_polices_restriction_type" => "required|array",
            "restriction_polices_cancellation_policy" => "required|string",
            "restriction_polices_excluded_product" => "required|string",
            "restriction_polices_surchange_account" => "required|string",
            "restriction_polices_surchange_apple" => "required|string",
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
            "baseinfor_condition_title" => "required|string",
            "baseinfor_description" => "required|string",
            "timeandday_config_days" => "required|array",
            "timeandday_config_time_range_from" => "required|string",
            "timeandday_config_time_range_to" => "required|string",
            "timeandday_config_valid_from_date" => "required|string",
            "timeandday_config_valid_until_date" => "required|string",
            "holiday_occasions_holiday_restrictions" => "required|array",
            "holiday_occasions_customer_blackout_dates" => "required|string",
            "holiday_occasions_special_occasions" => "required|array",
            "usage_limits_limit_per_user" => "required|string",
            "usage_limits_period" => "required|string",
            "usage_limits_min_purch_account" => "required|string",
            "usage_limits_max_discount_amount" => "required|string",
            "usage_limits_advance_booking_required" => "required|string",
            "usage_limits_group_size_required" => "required|string",
            "location_availability_venue_types" => "required|array",
            "location_availability_specific_branch" => "required|string",
            "location_availability_city" => "required|string",
            "location_availability_delivery_radius" => "required|string",
            "customer_membership_customer_type" => "required|string",
            "customer_membership_age_restriction" => "required|string",
            "customer_membership_min_membership_radius" => "required|string",
            "restriction_polices_restriction_type" => "required|array",
            "restriction_polices_cancellation_policy" => "required|string",
            "restriction_polices_excluded_product" => "required|string",
            "restriction_polices_surchange_account" => "required|string",
            "restriction_polices_surchange_apple" => "required|string",
            "status" => "nullable|string",
        ]);

        // Record find karo aur update karo
        $record = UsageTermManagement::findOrFail($id);
        $record->update($validated);

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
    public function assign_to_voucher(Request $request)
    {
            $VoucherType = VoucherType::all();
            return view('admin-views.usage_term.assign_of_voucher', compact('VoucherType'));

    }
    public function getAssignments($id)
    {
        $conditions = UsageTermManagement::all();
        // JSON banakar bhej do
        return response()->json([
            'voucherId' => $id,
            'conditions' => $conditions
        ]);

    }
    public function getAssignments_update(Request $request)
    {
        $validated = $request->validate([
            "voucher_id" => "required|integer",
            "voucher_update_ids" => "array",
        ]);

        $voucherId = $validated['voucher_id'];
        $checkedIds = $validated['voucher_update_ids'] ?? [];

        // Step 1: voucher_id ke saare records nikal lo
        $existingRecords = UsageTermManagement::where('voucher_id', $voucherId)->pluck('id')->toArray();

        // Step 2: Jo ids checked hain unko update karo
        if (!empty($checkedIds)) {
            foreach ($checkedIds as $id) {
                UsageTermManagement::updateOrCreate(
                    ['id' => $id],
                    ['voucher_id' => $voucherId]
                );
            }
        }

        // Step 3: Jo purane record the, par ab unchecked hain → unka voucher_id null kar do
        $uncheckedIds = array_diff($existingRecords, $checkedIds);

        if (!empty($uncheckedIds)) {
            UsageTermManagement::whereIn('id', $uncheckedIds)
                ->update(['voucher_id' => null]);
        }

        Toastr::success('Usages Term and Condition Updated successfully');
        return back();
    }

       public function preview_terms()
    {
      $VoucherType = VoucherType::all();
            return view('admin-views.usage_term.preview_term', compact('VoucherType'));
    }

    public function preview_terms_show($id)
    {
        $conditions = UsageTermManagement::where("voucher_id", $id)->get([
            'id',
            'baseinfor_condition_title',
            'baseinfor_description',
            'timeandday_config_days',
            'timeandday_config_time_range_from',
            'timeandday_config_time_range_to',
            'timeandday_config_valid_from_date',
            'timeandday_config_valid_until_date',
            'holiday_occasions_holiday_restrictions',
            'holiday_occasions_customer_blackout_dates',
            'holiday_occasions_special_occasions',
            'usage_limits_limit_per_user',
            'usage_limits_period',
            'usage_limits_min_purch_account',
            'usage_limits_max_discount_amount',
            'usage_limits_advance_booking_required',
            'usage_limits_group_size_required',
            'location_availability_venue_types',
            'location_availability_specific_branch',
            'location_availability_city',
            'location_availability_delivery_radius',
            'customer_membership_customer_type',
            'customer_membership_age_restriction',
            'customer_membership_min_membership_radius',
            'restriction_polices_restriction_type',
            'restriction_polices_cancellation_policy',
            'restriction_polices_excluded_product',
            'restriction_polices_surchange_account',
            'restriction_polices_surchange_apple',
            'voucher_id',
            'status',
            'created_at',
            'updated_at',
        ]);

        return response()->json([
            'voucherId' => $id,
            'conditions' => $conditions
        ]);
    }



}
