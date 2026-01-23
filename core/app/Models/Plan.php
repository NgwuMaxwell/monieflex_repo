<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $casts = [
        'roi_percentage' => 'decimal:2',
        'return_capital' => 'boolean'
    ];
}
