<?php
// Direct test script that bypasses all routing issues
// Run this with: php core/direct_test.php

echo "=== DIRECT REFERRAL COMMISSION TEST ===\n\n";

// Test 1: Check if we can access the database and models
echo "1. Testing database connection and models...\n";
try {
    // Test basic model access
    $userCount = \App\Models\User::count();
    $transactionCount = \App\Models\Transaction::count();
    $referralCount = \App\Models\Referral::count();
    
    echo "   ✅ Users: $userCount\n";
    echo "   ✅ Transactions: $transactionCount\n";
    echo "   ✅ Referrals: $referralCount\n";
    
    // Check if any users have referrers
    $usersWithReferrers = \App\Models\User::where('ref_by', '!=', null)->count();
    echo "   ✅ Users with referrers: $usersWithReferrers\n\n";
    
} catch (Exception $e) {
    echo "   ❌ Database error: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Test 2: Check admin settings
echo "2. Testing admin settings...\n";
try {
    $general = \App\Models\GeneralSetting::first();
    if ($general) {
        echo "   ✅ General settings found\n";
        echo "   - Deposit commission: " . ($general->deposit_commission ? 'YES' : 'NO') . "\n";
        echo "   - Plan subscribe commission: " . ($general->plan_subscribe_commission ? 'YES' : 'NO') . "\n";
        echo "   - PTC view commission: " . ($general->ptc_view_commission ? 'YES' : 'NO') . "\n";
        echo "   - Signup commission: " . ($general->signup_commission ? 'YES' : 'NO') . "\n\n";
    } else {
        echo "   ❌ No GeneralSetting found\n\n";
    }
} catch (Exception $e) {
    echo "   ❌ Admin settings error: " . $e->getMessage() . "\n\n";
}

// Test 3: Check referral settings
echo "3. Testing referral settings...\n";
try {
    $referralSettings = \App\Models\Referral::all();
    echo "   ✅ Found " . $referralSettings->count() . " referral settings\n";
    foreach ($referralSettings as $setting) {
        echo "   - Type: " . $setting->commission_type . ", Level: " . $setting->level . ", Percent: " . $setting->percent . "%\n";
    }
    echo "\n";
} catch (Exception $e) {
    echo "   ❌ Referral settings error: " . $e->getMessage() . "\n\n";
}

// Test 4: Force a referral credit directly
echo "4. Testing forced referral credit...\n";
try {
    $user = \App\Models\User::where('ref_by', '!=', null)->first();
    
    if (!$user) {
        echo "   ❌ No users with referrers found\n\n";
    } else {
        $referrer = \App\Models\User::find($user->ref_by);
        
        echo "   ✅ Found user: " . $user->username . " (ID: " . $user->id . ")\n";
        echo "   ✅ Found referrer: " . $referrer->username . " (ID: " . $referrer->id . ")\n";
        
        // Check current referral bonus transactions
        $beforeCount = \App\Models\Transaction::where('wallet', 'referral_bonus')->count();
        echo "   📊 Referral bonus transactions before: $beforeCount\n";
        
        // Create forced transaction
        $transaction = new \App\Models\Transaction();
        $transaction->user_id = $referrer->id;
        $transaction->wallet = 'referral_bonus';
        $transaction->amount = 100;
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = 'DIRECT TEST CREDIT';
        $transaction->trx = 'direct_test_' . time();
        $transaction->post_balance = 100;
        $transaction->save();
        
        echo "   ✅ Created forced referral credit of 100 NGN\n";
        
        // Check after count
        $afterCount = \App\Models\Transaction::where('wallet', 'referral_bonus')->count();
        echo "   📊 Referral bonus transactions after: $afterCount\n\n";
        
        echo "   🎯 RESULT: If dashboard shows ₦100, then dashboard works\n";
        echo "   🎯 RESULT: If dashboard shows ₦0, then dashboard query is broken\n";
    }
} catch (Exception $e) {
    echo "   ❌ Forced credit error: " . $e->getMessage() . "\n\n";
}

// Test 5: Test the ReferralCommissionService
echo "5. Testing ReferralCommissionService...\n";
try {
    $user = \App\Models\User::where('ref_by', '!=', null)->first();
    
    if ($user) {
        $commissionService = new \App\Services\ReferralCommissionService();
        
        echo "   🧪 Testing deposit commission...\n";
        $result1 = $commissionService->awardCommission($user, 'deposit', 1000, null, 'TEST_DEP_' . time());
        echo "   Result: " . ($result1 ? 'SUCCESS' : 'FAILED') . "\n";
        
        echo "   🧪 Testing PTC view commission...\n";
        $result2 = $commissionService->awardCommission($user, 'ptc_view', 100, null, 'TEST_PTC_' . time());
        echo "   Result: " . ($result2 ? 'SUCCESS' : 'FAILED') . "\n";
        
        echo "   🧪 Testing plan subscription commission...\n";
        $result3 = $commissionService->awardCommission($user, 'plan_subscription', 5000, null, 'TEST_PLAN_' . time());
        echo "   Result: " . ($result3 ? 'SUCCESS' : 'FAILED') . "\n\n";
        
        echo "   🎯 RESULT: If all FAILED, then commission logic is broken\n";
        echo "   🎯 RESULT: If any SUCCESS, then commissions are working\n";
    } else {
        echo "   ❌ No users with referrers found for commission test\n\n";
    }
} catch (Exception $e) {
    echo "   ❌ Commission service error: " . $e->getMessage() . "\n\n";
}

echo "=== TEST COMPLETE ===\n";
echo "Run this script with: php core/direct_test.php\n";