<?php

namespace App\Services;

use App\Models\CommissionLog;
use App\Models\Referral;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SimpleReferralService
{
    /**
     * Award referral commission directly to referrer
     */
    public function awardCommission(User $user, string $source, float $baseAmount, ?int $planId = null, ?string $referenceId = null): bool
    {
        try {
            // Get general settings
            $general = $this->getGeneralSettings();
            
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
            $commissionEnabled = $this->isCommissionEnabled($source, $general);
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

            // For deposit and PTC view, only use Level 1
            // For plan subscription, use multi-level
            $maxLevels = ($source === 'deposit' || $source === 'ptc_view') ? 1 : $commissionLevels->count();

            // Get Level 1 commission
            $commission = $commissionLevels->where('level', 1)->first();
            if (!$commission) {
                return false;
            }

            // Calculate commission amount
            $commissionAmount = ($baseAmount * $commission->percent) / 100;

            // Credit referrer's referral bonus wallet
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
            $transaction->trx = $referenceId ?: $this->generateTrx();
            $transaction->save();

            // Create commission log
            $commissionLog = new CommissionLog();
            $commissionLog->to_id = $referrer->id;
            $commissionLog->from_id = $user->id;
            $commissionLog->level = 1;
            $commissionLog->amount = $commissionAmount;
            $commissionLog->details = 'Referral commission from ' . $user->username;
            $commissionLog->type = $source;
            $commissionLog->trx = $referenceId ?: $this->generateTrx();
            $commissionLog->reference_id = $referenceId;
            $commissionLog->save();

            return true;
            
        } catch (\Exception $e) {
            \Log::error('SimpleReferralService failed: ' . $e->getMessage());
            return false;
        }
    }

    private function isCommissionEnabled(string $source, $general): bool
    {
        switch ($source) {
            case 'plan_subscription':
                return $general->plan_subscribe_commission;
            case 'deposit':
                return $general->deposit_commission;
            case 'ptc_view':
                return $general->ptc_view_commission;
            case 'signup':
                return $general->signup_commission;
            default:
                return false;
        }
    }

    private function getGeneralSettings()
    {
        return Cache::remember('GeneralSetting', 3600, function () {
            return \App\Models\GeneralSetting::first();
        });
    }

    private function generateTrx(): string
    {
        return strtoupper(uniqid('RC'));
    }
}