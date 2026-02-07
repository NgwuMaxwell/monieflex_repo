<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralBonus extends Model
{
    protected $fillable = [
        'user_id',
        'referral_id', 
        'amount',
        'type',
        'description',
        'paid'
    ];

    protected $casts = [
        'amount' => 'decimal:8',
        'paid' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function referral()
    {
        return $this->belongsTo(User::class, 'referral_id');
    }
}