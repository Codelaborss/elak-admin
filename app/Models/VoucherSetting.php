<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherSetting extends Model
{
    use HasFactory;

    protected $table = "voucher_settings";
        protected $fillable = [
            'validity_period' ,
            'specific_days_of_week' ,
            'holidays_occasions' ,
            'age_restriction' ,
            'group_size_requirement' ,
            'usage_limit_per_user' ,
            'usage_limit_per_store' ,
            'offer_validity_after_purchase' ,
            'general_restrictions' ,
        ];
    }



