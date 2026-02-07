<?php
// Direct test script to force a referral credit and check state
// Run this with: php core/force_test_credit.php

echo "=== FORCING REFERRAL CREDIT TEST ===\n\n";

try {
    // Initialize Laravel context
    require_once __DIR__ . '/bootstrap/app.php';
    
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    // Get a user with a referrer
    $user = \App\Models\User::where('ref_by', '!=', null)->first();
    
    if (!$user) {
        echo "❌ No users with referrers found in database\n";
        exit(1);
    }
    
    $referrer = \App\Models\User::find($user->ref_by);
    
    echo "✅ Found user: " . $user->username . " (ID: " . $user->id . ")\n";
    echo "✅ Found referrer: " . $referrer->username . " (ID: " . $referrer->id . ")\n\n";
    
    // Check current referral bonus transactions
    $beforeCount = \App\Models\Transaction::where('wallet', 'referral_bonus')->count();
    echo "📊 Referral bonus transactions before: " . $beforeCount . "\n\n";
    
    // Force a referral credit
    echo "⚡ Creating forced referral credit...\n";
    
    $transaction = new \App\Models\Transaction();
    $transaction->user_id = $referrer->id;
    $transaction->wallet = 'referral_bonus';
    $transaction->amount = 100;
    $transaction->charge = 0;
    $transaction->trx_type = '+';
    $transaction->details = 'FORCED TEST CREDIT';
    $transaction->trx = 'test_' . time();
    $transaction->post_balance = 100;
    $transaction->save();
    
    echo "✅ Successfully created forced referral credit!\n";
    echo "   - Amount: 100 NGN\n";
    echo "   - To: " . $referrer->username . "\n";
    echo "   - Transaction ID: " . $transaction->trx . "\n\n";
    
    // Check after count
    $afterCount = \App\Models\Transaction::where('wallet', 'referral_bonus')->count();
    echo "📊 Referral bonus transactions after: " . $afterCount . "\n\n";
    
    // Check admin settings
    $general = \App\Models\GeneralSetting::first();
    if ($general) {
        echo "🔧 Admin Settings:\n";
        echo "   - Deposit commission: " . ($general->deposit_commission ? 'YES' : 'NO') . "\n";
        echo "   - Plan subscribe commission: " . ($general->plan_subscribe_commission ? 'YES' : 'NO') . "\n";
        echo "   - PTC view commission: " . ($general->ptc_view_commission ? 'YES' : 'NO') . "\n";
        echo "   - Signup commission: " . ($general->signup_commission ? 'YES' : 'NO') . "\n\n";
    }
    
    // Check referral settings
    $referralSettings = \App\Models\Referral::all();
    echo "📋 Referral Settings (" . $referralSettings->count() . " found):\n";
    foreach ($referralSettings as $setting) {
        echo "   - Type: " . $setting->commission_type . ", Level: " . $setting->level . ", Percent: " . $setting->percent . "%\n";
    }
    
    echo "\n✅ TEST COMPLETED SUCCESSFULLY!\n";
    echo "   If dashboard shows ₦100, then dashboard is working\n";
    echo "   If dashboard shows ₦0, then dashboard query is broken\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}