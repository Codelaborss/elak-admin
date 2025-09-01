<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorTheme extends Model
{
    use HasFactory;

    protected $table = "color_themes";

    protected $fillable = [
        "color_name",
        "color_code",
        "color_gradient",
        "color_type",
        "status",
    ];
}
