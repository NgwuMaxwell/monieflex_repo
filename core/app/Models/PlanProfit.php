<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanProfit extends Model
{
    protected $fillable = ['user_id', 'plan_subscription_id', 'amount', 'day', 'total_days'];

    protected $casts = [
        'amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_subscription_id');
    }
}
