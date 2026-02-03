<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'image',
        'heading',
        'subheading',
        'order',
        'status',
        'animation_type',
        'slide_direction',
        'display_duration'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('order');
    }
}
