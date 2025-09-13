<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonuLimitSetting extends Model
{
    use HasFactory;

        protected $table = 'bonu_limit_settings';

    protected $fillable = [
        'category',
        'multi_level_bonus_configuration',
        'min_gift_ard',
        'max_gift_ard',
        'status',
    ];

}

