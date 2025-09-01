<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppBanner extends Model
{
    use HasFactory;
       protected $table = 'app_banners'; // ya jo bhi tumhara table ka naam hai

    protected $fillable = [
        'app_owner_name',
        'title',
        'type_priority',
        'image_or_video',
        'status',
        'zone_id',
        'banner_type',
        'store_id',
        'voucher_id',
        'category_id',
        'voucher_type',
        'external_lnk',
    ];
}
