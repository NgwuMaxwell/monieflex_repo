<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositAmount extends Model
{
    protected $table = 'deposit_amounts';

    protected $fillable = [
        'amount',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}