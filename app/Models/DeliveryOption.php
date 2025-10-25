<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOption extends Model
{
    use HasFactory;
       protected $table = 'delivery_options';

    protected $fillable = ['title', 'icon','status','des'];
}
