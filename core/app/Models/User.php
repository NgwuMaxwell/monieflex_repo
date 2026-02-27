<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'address' => 'object',
        'kyc_data' => 'object',
        'ver_code_send_at' => 'datetime',
        'profit_wallet' => 'decimal:2',
        'referral_bonus' => 'decimal:2'
    ];


    public function loginLogs()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('id','desc');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class)->where('status','!=',0);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class)->where('status','!=',0);
    }

    public function fullname(): Attribute
    {
        return new Attribute(
            get: fn () => $this->firstname . ' ' . $this->lastname,
        );
    }

    public function runningPlan(): Attribute
    {
        if ($this->plan && $this->expire_date > now()) {
            $running = true;
        }else{
            $running = false;
        }
        return new Attribute(
            get: fn () => $running,
        );
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function clicks()
    {
        return $this->hasMany(PtcView::class);
    }

    public function commissions()
    {
        return $this->hasMany(CommissionLog::class);
    }

    public function refBy()
    {
        return $this->belongsTo(User::class,'ref_by');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'ref_by');
    }

    public function referralBonuses()
    {
        return $this->hasMany(ReferralBonus::class, 'user_id');
    }

    public function earnedReferralBonuses()
    {
        return $this->hasMany(ReferralBonus::class, 'referral_id');
    }

    /**
     * Deduct amount from wallet balance with safety checks
     * 
     * @param float $amount
     * @return void
     * @throws \Exception
     */
    public function deductWallet($amount)
    {
        if ($amount <= 0) return;

        if ($this->balance < $amount) {
            throw new \Exception('Insufficient wallet balance');
        }

        $this->balance -= $amount;
        $this->balance = max(0, $this->balance);
        $this->save();
    }

    /**
     * Credit amount to wallet balance
     * 
     * @param float $amount
     * @return void
     */
    public function creditWallet($amount)
    {
        if ($amount <= 0) return;

        $this->balance += $amount;
        $this->save();
    }

    /**
     * Credit amount to profit wallet
     * 
     * @param float $amount
     * @return void
     */
    public function creditProfit($amount)
    {
        if ($amount <= 0) return;

        $this->profit_wallet += $amount;
        $this->save();
    }

    /**
     * Credit amount to referral bonus wallet
     * 
     * @param float $amount
     * @return void
     */
    public function creditReferralBonus($amount)
    {
        if ($amount <= 0) return;

        $this->referral_bonus += $amount;
        $this->save();
    }

    /**
     * Hard protection against negative wallet values
     * 
     * @return void
     */
    protected static function booted()
    {
        static::saving(function ($user) {
            $user->balance = max(0, $user->balance);
            $user->profit_wallet = max(0, $user->profit_wallet);
            $user->referral_bonus = max(0, $user->referral_bonus);
        });
    }

    /**
     * Get the user's profit wallet balance from database column
     * 
     * @return float
     */
    public function getProfitWalletAttribute()
    {
        return $this->attributes['profit_wallet'] ?? 0;
    }

    /**
     * Get the user's referral bonus balance from database column
     * 
     * @return float
     */
    public function getReferralBonusAttribute()
    {
        return $this->attributes['referral_bonus'] ?? 0;
    }


    // SCOPES
    public function scopeActive()
    {
        return $this->where('status', 1);
    }

    public function scopeBanned()
    {
        return $this->where('status', 0);
    }

    public function scopeEmailUnverified()
    {
        return $this->where('ev', 0);
    }

    public function scopeMobileUnverified()
    {
        return $this->where('sv', 0);
    }

    public function scopeKycUnverified()
    {
        return $this->where('kv', 0);
    }

    public function scopeKycPending()
    {
        return $this->where('kv', 2);
    }

    public function scopeEmailVerified()
    {
        return $this->where('ev', 1);
    }

    public function scopeMobileVerified()
    {
        return $this->where('sv', 1);
    }

    public function scopeWithBalance()
    {
        return $this->where('balance','>', 0);
    }

}