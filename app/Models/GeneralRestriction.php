<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralRestriction extends Model
{
    use HasFactory;
     protected $table = 'general_restrictions';
        protected $fillable = [
            "name",
            "status",
        ];
}
