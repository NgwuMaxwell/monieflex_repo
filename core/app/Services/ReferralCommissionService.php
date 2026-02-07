<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;

class ReferralCommissionService
{
    /**
     * Award referral commission to the user's referrer
     *
     * @param User $user The user who performed the action
     * @param string $source The source of the commission (deposit, ptc_view, plan_subscription)
     * @param float $amount The amount that generated the commission
     * @param mixed $sourceId Optional ID of the source (deposit ID, PTC ID, etc.)
     * @param string $trx Optional transaction reference
     * @return bool True if commission was awarded, false otherwise
     */
    public function awardCommission($user, $source, $amount, $sourceId = null, $trx = null)
    {
        try {
            // Get the referrer
            $referrer = $user->refBy;
            
            // Check if referrer exists and is active
            if (!$referrer || !$referrer->status || $referrer->ts == 0) {
                return false;
            }
            
            // Set commission percentage based on source
            $percent = 0;
            switch ($source) {
                case 'deposit':
                    $percent = 20; // 20% for deposits
                    break;
                case 'ptc_view':
                    $percent = 20; // 20% for PTC views
                    break;
                case 'plan_subscription':
                    $percent = 50; // 50% for plan subscriptions
                    break;
                default:
                    return false;
            }
            
            // Calculate commission amount
            $commission = ($amount * $percent) / 100;
            
            // Create the referral bonus transaction
            $transaction = new Transaction();
            $transaction->user_id = $referrer->id;
            $transaction->wallet = 'referral_bonus';
            $transaction->amount = $commission;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Referral commission from user ' . $user->id . ' (' . $source . ')';
            $transaction->trx = $trx ?: uniqid('ref_');
            $transaction->post_balance = $commission;
            $transaction->save();
            
            return true;
            
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Referral commission failed: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'source' => $source,
                'amount' => $amount,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }
}