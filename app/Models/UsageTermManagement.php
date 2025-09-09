<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsageTermManagement extends Model
{
    use HasFactory;

         protected $table = 'usage_term_management';
        protected $fillable = [
            "baseinfor_condition_title",
            "baseinfor_description",
            "timeandday_config_days",
            "timeandday_config_time_range_from",
            "timeandday_config_time_range_to",
            "timeandday_config_valid_from_date",
            "timeandday_config_valid_until_date",
            "holiday_occasions_holiday_restrictions",
            "holiday_occasions_customer_blackout_dates",
            "holiday_occasions_special_occasions",
            "usage_limits_limit_per_user",
            "usage_limits_period",
            "usage_limits_min_purch_account",
            "usage_limits_max_discount_amount",
            "usage_limits_advance_booking_required",
            "usage_limits_group_size_required",
            "location_availability_venue_types",
            "location_availability_specific_branch",
            "location_availability_city",
            "location_availability_delivery_radius",
            "customer_membership_customer_type",
            "customer_membership_age_restriction",
            "customer_membership_min_membership_radius",
            "restriction_polices_restriction_type",
            "restriction_polices_cancellation_policy",
            "restriction_polices_excluded_product",
            "restriction_polices_surchange_account",
            "restriction_polices_surchange_apple",
            "voucher_id",
            "status",
        ];
        protected $casts = [
            'timeandday_config_days' => 'array',
            'holiday_occasions_holiday_restrictions' => 'array',
            'holiday_occasions_special_occasions' => 'array',
            'location_availability_venue_types' => 'array',
            'restriction_polices_restriction_type' => 'array',
        ];


}

