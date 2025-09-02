<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherType extends Model
{
    use HasFactory;
    protected $table = "voucher_types";
       protected $fillable = [
        'name' ,
        'logo' ,
        'desc' ,
        'management_id' ,
        'status' ,
    ];
}
