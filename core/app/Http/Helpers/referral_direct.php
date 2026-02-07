<?php

use App\Models\CommissionLog;
use App\Models\Referral;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

/**
 * DIRECT REFERRAL COMMISSION FUNCTION
 * This function bypasses all complex services and directly credits referrers
 */
function directReferralCommission($userId, $source, $amount, $planId = null, $referenceId = null)
{
    try {
        // DEBUG: Log function call
        error_log("=== DIRECT REFERRAL COMMISSION CALLED ===");
        error_log("User ID: $userId, Source: $source, Amount: $amount");
        
        // Get the user
        $user = User::find($userId);
        if (!$user) {
            error_log("User not found: $userId");
            return false;
        }
        error_log("Found user: " . $user->username);

        // Get general settings
        $general = Cache::remember('GeneralSetting', 3600, function () {
            return \App\Models\GeneralSetting::first();
        });
        
        if (!$general) {
            error_log("General settings not found");
            return false;
        }
        error_log("General settings loaded");

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

        // Get Level 1 commission (for deposit and PTC view, we only use Level 1)
        $commission = $commissionLevels->where('level', 1)->first();
        if (!$commission) {
            return false;
        }

        // Calculate commission amount
        $commissionAmount = ($amount * $commission->percent) / 100;

        // DIRECTLY CREDIT THE REFERRER'S REFERRAL BONUS WALLET
        $referrer->referral_bonus += $commissionAmount;
        $referrer->save();

        // Create transaction record
        $transaction = new Transaction();
        $transaction->user_id = $referrer->id;
        $transaction->amount = $commissionAmount;
        $transaction->post_balance = $referrer->referral_bonus;
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = 'Referral commission from ' . $user->username . ' (' . ucfirst(str_replace('_', ' ', $source)) . ')';
        $transaction->remark = 'referral_commission';
        $transaction->trx = $referenceId ?: strtoupper(uniqid('RC'));
        $transaction->save();

        // Create commission log
        $commissionLog = new CommissionLog();
        $commissionLog->to_id = $referrer->id;
        $commissionLog->from_id = $user->id;
        $commissionLog->level = 1;
        $commissionLog->amount = $commissionAmount;
        $commissionLog->details = 'Referral commission from ' . $user->username;
        $commissionLog->type = $source;
        $commissionLog->trx = $referenceId ?: strtoupper(uniqid('RC'));
        $commissionLog->reference_id = $referenceId;
        $commissionLog->save();

        return true;
        
    } catch (\Exception $e) {
        // Log error for debugging
        error_log('DirectReferralCommission failed: ' . $e->getMessage());
        return false;
    }
}