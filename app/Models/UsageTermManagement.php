<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsageTermManagement extends Model
{
    use HasFactory;

         protected $table = 'usage_term_management';
      protected $fillable = ['term_type', 'term_title', 'term_dec', 'voucher_type' , 'management_type', 'customer_message', 'display_title', 'days', 'min_purchase_account', 'min_purchase_account', 'condition_is_not_met', 'message_when_condition_not_meet' , 'status'];
}

