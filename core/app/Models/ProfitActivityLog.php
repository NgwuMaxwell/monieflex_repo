<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfitActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'type',
        'name',
        'amount',
        'created_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function getTypeLabelAttribute()
    {
        switch ($this->type) {
            case 'total_profit':
                return 'Total Profit';
            case 'task':
                return 'Task Earning';
            default:
                return ucfirst($this->type);
        }
    }
}