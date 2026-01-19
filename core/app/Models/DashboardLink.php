<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DashboardLink extends Model
{
    protected $fillable = [
        'title',
        'url',
        'icon',
        'type',
        'status',
        'order'
    ];

    protected $casts = [
        'status' => 'boolean',
        'order' => 'integer'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeService($query)
    {
        return $query->where('type', 'service');
    }

    public function scopeContact($query)
    {
        return $query->where('type', 'contact');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
