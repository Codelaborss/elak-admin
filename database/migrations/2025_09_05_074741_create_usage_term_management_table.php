<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usage_term_management', function (Blueprint $table) {
            $table->id();
            $table->string("baseinfor_condition_title")->nullable();
            $table->string("baseinfor_description")->nullable();
            $table->string("timeandday_config_days")->nullable();
            $table->string("timeandday_config_time_range_from")->nullable();
            $table->string("timeandday_config_time_range_to")->nullable();
            $table->string("timeandday_config_valid_from_date")->nullable();
            $table->string("timeandday_config_valid_until_date")->nullable();
            $table->string("holiday_occasions_holiday_restrictions")->nullable();
            $table->string("holiday_occasions_customer_blackout_dates")->nullable();
            $table->string("holiday_occasions_special_occasions")->nullable();
            $table->string("usage_limits_limit_per_user")->nullable();
            $table->string("usage_limits_period")->nullable();
            $table->string("usage_limits_min_purch_account")->nullable();
            $table->string("usage_limits_max_discount_amount")->nullable();
            $table->string("usage_limits_advance_booking_required")->nullable();
            $table->string("usage_limits_group_size_required")->nullable();
            $table->string("location_availability_venue_types")->nullable();
            $table->string("location_availability_specific_branch")->nullable();
            $table->string("location_availability_city")->nullable();
            $table->string("location_availability_delivery_radius")->nullable();
            $table->string("customer_membership_customer_type")->nullable();
            $table->string("customer_membership_age_restriction")->nullable();
            $table->string("customer_membership_min_membership_radius")->nullable();
            $table->string("restriction_polices_restriction_type")->nullable();
            $table->string("restriction_polices_cancellation_policy")->nullable();
            $table->string("restriction_polices_excluded_product")->nullable();
            $table->string("restriction_polices_surchange_account")->nullable();
            $table->string("restriction_polices_surchange_apple")->nullable();
            $table->string("voucher_id")->nullable();
            $table->string("status")->default("active");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usage_term_management');
    }
};
