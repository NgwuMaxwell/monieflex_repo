<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanProfit extends Model
{
    protected $fillable = ['user_id', 'plan_id', 'daily_profit', 'profit_date'];

    protected $casts = [
        'profit_date' => 'date',
        'daily_profit' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
