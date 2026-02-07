<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ReferralCommissionService;

class TestReferralSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:referral-system';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the referral commission system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== DIRECT REFERRAL COMMISSION TEST ===');
        $this->newLine();

        // Test 1: Check if we can access the database and models
        $this->info('1. Testing database connection and models...');
        try {
            $userCount = \App\Models\User::count();
            $transactionCount = \App\Models\Transaction::count();
            $referralCount = \App\Models\Referral::count();
            
            $this->info("   ✅ Users: $userCount");
            $this->info("   ✅ Transactions: $transactionCount");
            $this->info("   ✅ Referrals: $referralCount");
            
            $usersWithReferrers = \App\Models\User::where('ref_by', '!=', null)->count();
            $this->info("   ✅ Users with referrers: $usersWithReferrers");
            $this->newLine();
            
        } catch (\Exception $e) {
            $this->error("   ❌ Database error: " . $e->getMessage());
            return 1;
        }

        // Test 2: Check admin settings
        $this->info('2. Testing admin settings...');
        try {
            $general = \App\Models\GeneralSetting::first();
            if ($general) {
                $this->info("   ✅ General settings found");
                $this->info("   - Deposit commission: " . ($general->deposit_commission ? 'YES' : 'NO'));
                $this->info("   - Plan subscribe commission: " . ($general->plan_subscribe_commission ? 'YES' : 'NO'));
                $this->info("   - PTC view commission: " . ($general->ptc_view_commission ? 'YES' : 'NO'));
                $this->info("   - Signup commission: " . ($general->signup_commission ? 'YES' : 'NO'));
                $this->newLine();
            } else {
                $this->error("   ❌ No GeneralSetting found");
                $this->newLine();
            }
        } catch (\Exception $e) {
            $this->error("   ❌ Admin settings error: " . $e->getMessage());
            $this->newLine();
        }

        // Test 3: Check referral settings
        $this->info('3. Testing referral settings...');
        try {
            $referralSettings = \App\Models\Referral::all();
            $this->info("   ✅ Found " . $referralSettings->count() . " referral settings");
            foreach ($referralSettings as $setting) {
                $this->info("   - Type: " . $setting->commission_type . ", Level: " . $setting->level . ", Percent: " . $setting->percent . "%");
            }
            $this->newLine();
        } catch (\Exception $e) {
            $this->error("   ❌ Referral settings error: " . $e->getMessage());
            $this->newLine();
        }

        // Test 4: Force a referral credit directly
        $this->info('4. Testing forced referral credit...');
        try {
            // Find a user with a valid referrer
            $user = null;
            $referrer = null;
            
            $usersWithReferrers = \App\Models\User::where('ref_by', '!=', null)->get();
            foreach ($usersWithReferrers as $potentialUser) {
                $potentialReferrer = \App\Models\User::find($potentialUser->ref_by);
                if ($potentialReferrer) {
                    $user = $potentialUser;
                    $referrer = $potentialReferrer;
                    break;
                }
            }
            
            if (!$user || !$referrer) {
                $this->error("   ❌ No users with valid referrers found");
                $this->newLine();
            } else {
                $this->info("   ✅ Found user: " . $user->username . " (ID: " . $user->id . ")");
                $this->info("   ✅ Found referrer: " . $referrer->username . " (ID: " . $referrer->id . ")");
                
                $beforeCount = \App\Models\Transaction::where('wallet', 'referral_bonus')->count();
                $this->info("   📊 Referral bonus transactions before: $beforeCount");
                
                $transaction = new \App\Models\Transaction();
                $transaction->user_id = $referrer->id;
                $transaction->wallet = 'referral_bonus';
                $transaction->amount = 100;
                $transaction->charge = 0;
                $transaction->trx_type = '+';
                $transaction->details = 'CONSOLE TEST CREDIT';
                $transaction->trx = 'console_test_' . time();
                $transaction->post_balance = 100;
                $transaction->save();
                
                $this->info("   ✅ Created forced referral credit of 100 NGN");
                
                $afterCount = \App\Models\Transaction::where('wallet', 'referral_bonus')->count();
                $this->info("   📊 Referral bonus transactions after: $afterCount");
                $this->newLine();
                
                $this->info("   🎯 RESULT: If dashboard shows ₦100, then dashboard works");
                $this->info("   🎯 RESULT: If dashboard shows ₦0, then dashboard query is broken");
                $this->newLine();
            }
        } catch (\Exception $e) {
            $this->error("   ❌ Forced credit error: " . $e->getMessage());
            $this->newLine();
        }

        // Test 5: Test the ReferralCommissionService
        $this->info('5. Testing ReferralCommissionService...');
        try {
            // Find a user with a valid referrer
            $user = null;
            $referrer = null;
            
            $usersWithReferrers = \App\Models\User::where('ref_by', '!=', null)->get();
            foreach ($usersWithReferrers as $potentialUser) {
                $potentialReferrer = \App\Models\User::find($potentialUser->ref_by);
                if ($potentialReferrer) {
                    $user = $potentialUser;
                    $referrer = $potentialReferrer;
                    break;
                }
            }
            
            if ($user && $referrer) {
                $this->info("   ✅ Testing with user: " . $user->username . " (ID: " . $user->id . ")");
                $this->info("   ✅ Testing with referrer: " . $referrer->username . " (ID: " . $referrer->id . ")");
                
                $commissionService = new ReferralCommissionService();
                
                $this->info("   🧪 Testing deposit commission...");
                $result1 = $commissionService->awardCommission($user, 'deposit', 1000, null, 'TEST_DEP_' . time());
                $this->info("   Result: " . ($result1 ? 'SUCCESS' : 'FAILED'));
                
                $this->info("   🧪 Testing PTC view commission...");
                $result2 = $commissionService->awardCommission($user, 'ptc_view', 100, null, 'TEST_PTC_' . time());
                $this->info("   Result: " . ($result2 ? 'SUCCESS' : 'FAILED'));
                
                $this->info("   🧪 Testing plan subscription commission...");
                $result3 = $commissionService->awardCommission($user, 'plan_subscription', 5000, null, 'TEST_PLAN_' . time());
                $this->info("   Result: " . ($result3 ? 'SUCCESS' : 'FAILED'));
                $this->newLine();
                
                $this->info("   🎯 RESULT: If all FAILED, then commission logic is broken");
                $this->info("   🎯 RESULT: If any SUCCESS, then commissions are working");
                $this->newLine();
            } else {
                $this->error("   ❌ No users with valid referrers found for commission test");
                $this->newLine();
            }
        } catch (\Exception $e) {
            $this->error("   ❌ Commission service error: " . $e->getMessage());
            $this->newLine();
        }

        $this->info('=== TEST COMPLETE ===');
        return 0;
    }
}