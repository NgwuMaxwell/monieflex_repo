<?php

// Test script to verify real deposit referral commission
require_once 'core/bootstrap/app.php';

use App\Models\Deposit;
use App\Models\User;
use App\Models\Transaction;
use App\Http\Controllers\Gateway\PaymentController;

echo "=== REAL DEPOSIT REFERRAL TEST ===\n\n";

try {
    // Find a user with a referrer
    $user = User::whereNotNull('ref_by')->where('status', 1)->first();
    if (!$user) {
        echo "❌ No users with referrers found\n";
        exit;
    }
    
    $referrer = User::find($user->ref_by);
    if (!$referrer) {
        echo "❌ Referrer not found\n";
        exit;
    }
    
    echo "✅ Found user: {$user->username} (ID: {$user->id})\n";
    echo "✅ Found referrer: {$referrer->username} (ID: {$referrer->id})\n\n";
    
    // Count existing referral bonus transactions
    $beforeCount = Transaction::where('user_id', $referrer->id)
        ->where('wallet', 'referral_bonus')
        ->count();
    echo "📊 Referral bonus transactions before: $beforeCount\n\n";
    
    // Create a test deposit
    $deposit = new Deposit();
    $deposit->user_id = $user->id;
    $deposit->method_code = 1001; // Test gateway
    $deposit->method_currency = 'USD';
    $deposit->amount = 1000;
    $deposit->charge = 10;
    $deposit->rate = 1;
    $deposit->final_amo = 1010;
    $deposit->btc_amo = 0;
    $deposit->btc_wallet = "";
    $deposit->trx = uniqid('test_');
    $deposit->try = 0;
    $deposit->status = 0; // Pending
    $deposit->save();
    
    echo "✅ Created test deposit: {$deposit->trx}\n";
    echo "✅ Deposit amount: ₦{$deposit->amount}\n\n";
    
    // Simulate successful deposit processing
    echo "🔄 Processing deposit...\n";
    PaymentController::userDataUpdate($deposit);
    
    // Check if referral bonus was created
    $afterCount = Transaction::where('user_id', $referrer->id)
        ->where('wallet', 'referral_bonus')
        ->count();
    
    echo "📊 Referral bonus transactions after: $afterCount\n\n";
    
    if ($afterCount > $beforeCount) {
        $newTransaction = Transaction::where('user_id', $referrer->id)
            ->where('wallet', 'referral_bonus')
            ->where('details', 'LIKE', '%Deposit referral test%')
            ->orderBy('id', 'desc')
            ->first();
            
        echo "🎉 SUCCESS! Referral bonus created!\n";
        echo "💰 Amount: ₦{$newTransaction->amount}\n";
        echo "📝 Details: {$newTransaction->details}\n";
        echo "🆔 Transaction: {$newTransaction->trx}\n";
        echo "\n🎯 RESULT: Real deposit referral commission is WORKING!\n";
    } else {
        echo "❌ FAILED! No referral bonus created\n";
        echo "\n🎯 RESULT: Real deposit referral commission is NOT working\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "❌ File: " . $e->getFile() . "\n";
    echo "❌ Line: " . $e->getLine() . "\n";
}

echo "\n=== TEST COMPLETE ===\n";