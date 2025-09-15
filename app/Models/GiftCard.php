<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model
{
    use HasFactory;
        protected $table = 'gift_cards';
        protected $fillable = [
            "occasion_name",
            "business_category",
            "display_priority",
            "occasion_gallery",
            "hidden_store_id",
            "status",
        ];
}
