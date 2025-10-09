<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkManagement extends Model
{
    use HasFactory;
       protected $table = 'work_management';
        protected $fillable = [
            'voucher_id',
            'guid_title',
            'purchase_process',
            'payment_confirm',
            'voucher_deliver',
            'redemption_process',
            'account_management',
            'status',
        ];

        protected $casts = [
        'purchase_process' => 'array',
        'payment_confirm' => 'array',
        'voucher_deliver' => 'array',
        'redemption_process' => 'array',
        'account_management' => 'array',
    ];

    }
