<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $casts = [
        'price' => 'float',
        'roi_percentage' => 'float',
        'return_capital' => 'boolean'
    ];
}
