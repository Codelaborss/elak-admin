<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftOccasions extends Model
{
    use HasFactory;

    protected $table = 'gift_occasions';

    protected $fillable = ['title', 'icon','status'];

}
