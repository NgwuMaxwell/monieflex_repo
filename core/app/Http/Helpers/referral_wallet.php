<?php

use App\Models\Transaction;
use App\Models\Referral;
use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

/**
 * GET REFERRAL BONUS BALANCE FROM TRANSACTIONS
 * This is how your system actually calculates balances
 */
function getReferralBonusBalance($userId)
{
    return Transaction::where('user_id', $userId)
        ->where('wallet', 'referral_bonus')
        ->selectRaw("SUM(CASE WHEN trx_type='+' THEN amount ELSE -amount END) as total")
        ->value('total') ?? 0;
}

/**
 * CREDIT REFERRAL BONUS VIA TRANSACTION
 * This is the ONLY way your system will recognize the credit
 */
function creditReferralTransaction($userId, $amount, $source, $description = null, $referenceId = null)
{
    try {
        $user = User::find($userId);
        if (!$user) {
            return false;
        }

        // Get current balance from transactions
        $currentBalance = getReferralBonusBalance($userId);
        $newBalance = $currentBalance + $amount;

        // Create the transaction record
        $transaction = new Transaction();
        $transaction->user_id = $userId;
        $transaction->amount = $amount;
        $transaction->post_balance = $newBalance;
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = $description ?: ucfirst(str_replace('_', ' ', $source)) . ' referral commission';
        $transaction->remark = 'referral_commission';
        $transaction->trx = $referenceId ?: strtoupper(uniqid('RC'));
        $transaction->wallet = 'referral_bonus'; // THIS IS THE KEY - wallet field
        $transaction->save();

        return true;

    } catch (\Exception $e) {
        error_log('CreditReferralTransaction failed: ' . $e->getMessage());
        return false;
    }
}

/**
 * CALCULATE COMMISSION WITH ADMIN SETTINGS
 * Uses the correct admin settings and commission types
 */
function calculateReferralCommission($userId, $source, $amount, $planId = null, $referenceId = null)
{
    try {
        $user = User::find($userId);
        if (!$user) {
            return false;
        }

        // Get general settings
        $general = Cache::remember('GeneralSetting', 3600, function () {
            return GeneralSetting::first();
        });
        
        if (!$general) {
            return false;
        }

        // Map source to commission type
        $commissionTypeMap = [
            'plan_subscription' => 'plan_subscribe_commission',
            'deposit' => 'deposit_commission',
            'ptc_view' => 'ptc_view_commission',
            'signup' => 'signup_commission'
        ];
        
        if (!isset($commissionTypeMap[$source])) {
            return false;
        }
        
        $commissionType = $commissionTypeMap[$source];
        
        // Check if commission type is enabled
        $commissionEnabled = false;
        switch ($source) {
            case 'plan_subscription':
                $commissionEnabled = $general->plan_subscribe_commission;
                break;
            case 'deposit':
                $commissionEnabled = $general->deposit_commission;
                break;
            case 'ptc_view':
                $commissionEnabled = $general->ptc_view_commission;
                break;
            case 'signup':
                $commissionEnabled = $general->signup_commission;
                break;
        }
        
        if (!$commissionEnabled) {
            return false;
        }

        // Load commission levels
        $commissionLevels = Referral::where('commission_type', $commissionType)->get();
        if ($commissionLevels->isEmpty()) {
            return false;
        }

        // Get referrer
        $referrer = $user->refBy;
        if (!$referrer) {
            return false;
        }

        // Skip inactive referrers
        if (!$referrer->status || $referrer->ts == 0) {
            return false;
        }

        // Calculate commissions based on source type
        if ($source == 'plan_subscription') {
            // Multi-level for plan subscriptions
            $upline = $referrer;
            $currentUser = $user;
            
            foreach ($commissionLevels as $level) {
                if (!$upline) break;
                
                $commissionAmount = ($amount * $level->percent) / 100;
                if ($commissionAmount > 0) {
                    creditReferralTransaction($upline->id, $commissionAmount, $source, 
                        "Level {$level->level} plan subscription commission from {$currentUser->username}");
                }
                
                // Move up the referral chain
                $upline = $upline->refBy;
            }
        } else {
            // Level 1 only for deposit, PTC view, and signup
            $commission = $commissionLevels->where('level', 1)->first();
            if ($commission) {
                $commissionAmount = ($amount * $commission->percent) / 100;
                if ($commissionAmount > 0) {
                    creditReferralTransaction($referrer->id, $commissionAmount, $source, 
                        ucfirst(str_replace('_', ' ', $source)) . " commission from {$user->username}", 
                        $referenceId);
                }
            }
        }

        return true;

    } catch (\Exception $e) {
        error_log('CalculateReferralCommission failed: ' . $e->getMessage());
        return false;
    }
}