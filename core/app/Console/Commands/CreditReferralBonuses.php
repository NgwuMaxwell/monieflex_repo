<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Transaction;
use App\Models\CommissionLog;
use App\Models\Referral;
use App\Models\Plan;

class CreditReferralBonuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'referrals:credit-bonuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Credit referral bonuses for existing referrals';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('=== Crediting Referral Bonuses for Existing Referrals ===');

        // Get all users who have referred someone
        $usersWithReferrals = User::where('ref_by', '>', 0)
                                  ->whereHas('plan')
                                  ->with(['refBy', 'plan'])
                                  ->get();

        if ($usersWithReferrals->isEmpty()) {
            $this->info('No users with existing referrals found.');
            return 0;
        }

        $this->info('Found ' . $usersWithReferrals->count() . ' users with referrals.');

        // Get referral commission settings
        $referralSettings = Referral::where('commission_type', 'plan_subscribe_commission')
                                   ->orderBy('level', 'asc')
                                   ->get();

        if ($referralSettings->isEmpty()) {
            $this->error('No referral commission settings found. Please configure referral commissions first.');
            return 1;
        }

        $this->info('Referral commission settings:');
        foreach ($referralSettings as $setting) {
            $this->line('  Level ' . $setting->level . ': ' . $setting->percent . '%');
        }

        $processedCount = 0;
        $totalBonusAmount = 0;

        foreach ($usersWithReferrals as $referee) {
            // Check if this user's plan purchase would trigger a referral bonus
            if (!$referee->plan) {
                continue;
            }

            $this->info("Processing referral for user: " . $referee->email);
            $this->line("  Plan: " . $referee->plan->name . " (Price: " . $referee->plan->price . ")");

            // Find the referrer (user who referred this user)
            $referrer = $referee->refBy;
            if (!$referrer) {
                $this->line("  No referrer found. Skipping.");
                continue;
            }

            $this->line("  Referrer: " . $referrer->email);

            // Check if referrer has an active plan with referral levels
            if (!$referrer->plan) {
                $this->line("  Referrer has no active plan. Skipping.");
                continue;
            }

            // Determine the referral level (we'll assume level 1 for direct referrals)
            $level = 1;

            // Check if referrer's plan supports this referral level
            if ($level > $referrer->plan->ref_level) {
                $this->line("  Referrer's plan doesn't support level " . $level . " referrals. Skipping.");
                continue;
            }

            // Get the commission rate for this level
            $commissionSetting = $referralSettings->where('level', $level)->first();
            if (!$commissionSetting) {
                $this->line("  No commission setting for level " . $level . ". Skipping.");
                continue;
            }

            // Calculate the referral bonus
            $bonusAmount = ($referee->plan->price * $commissionSetting->percent) / 100;

            $this->line("  Calculated bonus: " . $bonusAmount . " (" . $commissionSetting->percent . "% of " . $referee->plan->price . ")");

            // Check if this bonus has already been credited
            $existingBonus = Transaction::where('user_id', $referrer->id)
                                       ->where('remark', 'referral_bonus')
                                       ->where('details', 'LIKE', '%' . $referee->username . '%')
                                       ->exists();

            if ($existingBonus) {
                $this->line("  Bonus already credited. Skipping.");
                continue;
            }

            // Credit the referral bonus
            try {
                // Generate a transaction ID
                $trx = 'RB' . strtoupper(uniqid());

                // Add to referrer's referral bonus wallet
                $referrer->referral_bonus += $bonusAmount;
                $referrer->save();

                // Create transaction record
                Transaction::create([
                    'user_id' => $referrer->id,
                    'amount' => $bonusAmount,
                    'post_balance' => $referrer->referral_bonus,
                    'charge' => 0,
                    'trx_type' => '+',
                    'wallet' => 'referral_bonus', // Add wallet field
                    'details' => '1st level referral bonus from ' . $referee->username . ' for ' . $referee->plan->name . ' plan purchase',
                    'remark' => 'referral_bonus',
                    'trx' => $trx,
                    'created_at' => now()
                ]);

                // Create commission log
                CommissionLog::create([
                    'to_id' => $referrer->id,
                    'from_id' => $referee->id,
                    'level' => $level,
                    'amount' => $bonusAmount,
                    'details' => '1st level referral bonus from ' . $referee->username . ' for plan purchase',
                    'type' => 'plan_subscribe_commission',
                    'trx' => $trx,
                    'created_at' => now()
                ]);

                $this->info("  ✅ Successfully credited " . $bonusAmount . " referral bonus to " . $referrer->email);

                $processedCount++;
                $totalBonusAmount += $bonusAmount;

            } catch (\Exception $e) {
                $this->error("  ❌ Error crediting bonus: " . $e->getMessage());
            }
        }

        $this->info("\n=== Summary ===");
        $this->info("Processed " . $processedCount . " referral bonuses");
        $this->info("Total bonus amount credited: " . $totalBonusAmount);
        $this->info("✅ Referral bonus crediting completed!");

        return 0;
    }
}