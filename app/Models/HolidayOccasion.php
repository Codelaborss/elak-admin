<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayOccasion extends Model
{
    use HasFactory;
     protected $table = 'holiday_occasions';
        protected $fillable = [
            "name",
            "status",
        ];
}
