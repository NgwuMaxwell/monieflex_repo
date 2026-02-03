<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarouselSetting extends Model
{
    protected $fillable = [
        'animation_type',
        'direction',
        'display_duration'
    ];

    protected $casts = [
        'display_duration' => 'integer'
    ];

    public static function getSettings()
    {
        return self::firstOrCreate([], [
            'animation_type' => 'slide',
            'direction' => 'left',
            'display_duration' => 5
        ]);
    }
}