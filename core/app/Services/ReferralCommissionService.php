<?php

namespace App\Services;

use App\Models\CommissionLog;
use App\Models\Referral;
use App\Models\Transaction;
use App\Models\User;
use App\Notify\Notify;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ReferralCommissionService
{
    /**
     * Award referral commission to referrer
     *
     * @param User $user The user who triggered the commission
     * @param string $source The source type (plan_subscription, deposit, ptc_view, signup)
     * @param float $baseAmount The base amount to calculate commission from
     * @param int|null $planId The plan ID (for plan subscriptions)
     * @param string|null $referenceId The reference transaction ID
     * @return bool
     */
    public function awardCommission(User $user, string $source, float $baseAmount, ?int $planId = null, ?string $referenceId = null): bool
    {
        // Validate source parameter
        $validSources = ['plan_subscription', 'deposit', 'ptc_view', 'signup'];
        if (!in_array($source, $validSources)) {
            return false;
        }

        // Get general settings
        $general = $this->getGeneralSettings();
        
        // Map source to correct commission type and check if enabled
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
        
        // Check if this commission type is enabled in admin settings
        $commissionSettingEnabled = $this->isCommissionEnabled($source, $general);
        
        if (!$commissionSettingEnabled) {
            return false;
        }

        // Load commission percentages for the specific source
        $commissionLevels = Referral::where('commission_type', $commissionType)->get();

        if ($commissionLevels->isEmpty()) {
            return false;
        }

        // Get referrer
        $referrer = $user->refBy;
        if (!$referrer) {
            return false;
        }

        // Skip inactive or blocked referrers
        if (!$referrer->status || $referrer->ts == 0) {
            return false;
        }

        // For deposit and PTC view, only use Level 1
        // For plan subscription, use multi-level up to allowed depth
        $maxLevels = ($source === 'deposit' || $source === 'ptc_view') ? 1 : $commissionLevels->count();

        $transactions = [];
        $commissionLogs = [];
        $tempUser = $user;
        $i = 1;

        while ($i <= $maxLevels) {
            $referer = $tempUser->refBy;
            
            // Stop if no referrer found
            if (!$referer) {
                break;
            }

            // Skip inactive or blocked referrers
            if (!$referer->status || $referer->ts == 0) {
                $tempUser = $referer;
                $i++;
                continue;
            }

            // For deposit and PTC view, only process Level 1
            if (($source === 'deposit' || $source === 'ptc_view') && $i > 1) {
                break;
            }

            // For plan subscription, determine allowed referral depth
            $allowedDepth = null;
            
            if ($source === 'plan_subscription' && $planId) {
                // Use plan-specific referral depth
                $plan = \App\Models\Plan::find($planId);
                if ($plan && $referer->plan) {
                    $allowedDepth = $referer->plan->ref_level;
                }
            } else {
                // Use global admin referral depth
                $allowedDepth = $general->referral_depth ?? 10; // Default to 10 levels if not set
            }

            // Check if we've exceeded the allowed depth
            if ($allowedDepth && $i > $allowedDepth) {
                break;
            }

            // Get commission percentage for this level
            $commission = $commissionLevels->where('level', $i)->first();
            
            if (!$commission) {
                break;
            }

            // Calculate commission amount
            $commissionAmount = ($baseAmount * $commission->percent) / 100;

            // Get current referral bonus balance from transactions
            $currentBalance = $this->getReferralBonusBalance($referer->id);
            $newBalance = $currentBalance + $commissionAmount;

            // Record transaction (this is what the dashboard reads)
            $transactions[] = [
                'user_id' => $referer->id,
                'amount' => $commissionAmount,
                'post_balance' => $newBalance,
                'charge' => 0,
                'trx_type' => '+',
                'wallet' => 'referral_bonus', // KEY: This is what the dashboard reads
                'details' => $this->getCommissionDetails($i, $user->username, $source),
                'remark' => 'referral_commission',
                'trx' => $referenceId ?: $this->generateTrx(),
                'created_at' => now()
            ];

            // Record commission log
            $commissionLogs[] = [
                'to_id' => $referer->id,
                'from_id' => $user->id,
                'level' => $i,
                'amount' => $commissionAmount,
                'details' => $this->getCommissionDetails($i, $user->username, $source),
                'type' => $source,
                'trx' => $referenceId ?: $this->generateTrx(),
                'reference_id' => $referenceId,
                'created_at' => now()
            ];

            // Send notification
            $this->sendCommissionNotification($referer, $commissionAmount, $i, $source, $user->username, $referenceId);

            $tempUser = $referer;
            $i++;
        }

        // Use database transaction for atomicity
        if (!empty($transactions) || !empty($commissionLogs)) {
            try {
                DB::transaction(function () use ($transactions, $commissionLogs) {
                    if (!empty($transactions)) {
                        Transaction::insert($transactions);
                    }
                    if (!empty($commissionLogs)) {
                        CommissionLog::insert($commissionLogs);
                    }
                });
                return true;
            } catch (\Exception $e) {
                \Log::error('Referral commission transaction failed: ' . $e->getMessage());
                return false;
            }
        }

        return false;
    }

    /**
     * Check if commission type is enabled
     */
    private function isCommissionEnabled(string $source, $general): bool
    {
        switch ($source) {
            case 'plan_subscription':
                return $general && $general->plan_subscribe_commission;
            case 'deposit':
                return $general && $general->deposit_commission;
            case 'ptc_view':
                return $general && $general->ptc_view_commission;
            case 'signup':
                return $general && $general->signup_commission;
            default:
                return false;
        }
    }

    /**
     * Get commission details text
     */
    private function getCommissionDetails(int $level, string $username, string $source): string
    {
        return $this->ordinal($level) . ' level referral commission from ' . $username . ' (' . ucfirst(str_replace('_', ' ', $source)) . ')';
    }

    /**
     * Send commission notification
     */
    private function sendCommissionNotification(User $referer, float $amount, int $level, string $source, string $referee, ?string $referenceId): void
    {
        notify($referer, 'REFERRAL_COMMISSION', [
            'amount' => showAmount($amount),
            'post_balance' => showAmount($referer->referral_bonus),
            'trx' => $referenceId ?: $this->generateTrx(),
            'level' => $this->ordinal($level),
            'type' => ucfirst(str_replace('_', ' ', $source)),
            'referee' => $referee
        ]);
    }

    /**
     * Generate transaction ID
     */
    private function generateTrx(): string
    {
        return strtoupper(uniqid('RC'));
    }

    /**
     * Get general settings with caching
     */
    private function getGeneralSettings()
    {
        return Cache::remember('GeneralSetting', 3600, function () {
            return \App\Models\GeneralSetting::first();
        });
    }

    /**
     * Get ordinal suffix
     */
    private function ordinal(int $number): string
    {
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
            return $number . 'th';
        } else {
            return $number . $ends[$number % 10];
        }
    }

    /**
     * Get referral bonus balance from transactions
     */
    private function getReferralBonusBalance(int $userId): float
    {
        return Transaction::where('user_id', $userId)
            ->where('wallet', 'referral_bonus')
            ->selectRaw("SUM(CASE WHEN trx_type='+' THEN amount ELSE -amount END) as total")
            ->value('total') ?? 0;
    }
}
