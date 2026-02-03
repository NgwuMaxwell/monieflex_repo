<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'animation_type',
        'slide_direction',
        'display_duration',
    ];
}
