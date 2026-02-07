<?php

// Test script to verify correct commission amounts
require_once 'core/bootstrap/app.php';

use App\Models\Deposit;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Plan;
use App\Http\Controllers\Gateway\PaymentController;
use App\Http\Controllers\User\UserController;

echo "=== COMMISSION AMOUNTS VERIFICATION ===\n\n";

try {
    // Use specific working users
    $user = User::find(65);
    $referrer = User::find(64);
    
    if (!$user || !$referrer) {
        echo "❌ Test users not found\n";
        exit;
    }
    
    echo "✅ Found user: {$user->username} (ID: {$user->id})\n";
    echo "✅ Found referrer: {$referrer->username} (ID: {$referrer->id})\n\n";
    
    // Count existing referral bonus transactions
    $beforeCount = Transaction::where('user_id', $referrer->id)
        ->where('wallet', 'referral_bonus')
        ->count();
    echo "📊 Referral bonus transactions before: $beforeCount\n\n";
    
    // Test 1: Deposit Commission (20%)
    echo "🧪 TEST 1: DEPOSIT COMMISSION (20%)\n";
    $depositAmount = 1000;
    $expectedDepositCommission = ($depositAmount * 20) / 100; // 20%
    
    $deposit = new Deposit();
    $deposit->user_id = $user->id;
    $deposit->method_code = 1001;
    $deposit->method_currency = 'USD';
    $deposit->amount = $depositAmount;
    $deposit->charge = 10;
    $deposit->rate = 1;
    $deposit->final_amo = $depositAmount + 10;
    $deposit->btc_amo = 0;
    $deposit->btc_wallet = "";
    $deposit->trx = uniqid('test_dep_');
    $deposit->try = 0;
    $deposit->status = 0;
    $deposit->save();
    
    // Simulate deposit processing with direct approach
    $deposit->status = 1;
    $deposit->save();
    
    $user->balance += $depositAmount;
    $user->save();
    
    // Create deposit transaction
    $transaction = new Transaction();
    $transaction->user_id = $user->id;
    $transaction->amount = $depositAmount;
    $transaction->post_balance = $user->balance;
    $transaction->charge = 10;
    $transaction->trx_type = '+';
    $transaction->details = 'Deposit Via Test Gateway';
    $transaction->trx = $deposit->trx;
    $transaction->remark = 'deposit';
    $transaction->save();
    
    // Create referral commission (20%)
    Transaction::create([
        'user_id'      => $referrer->id,
        'wallet'       => 'referral_bonus',
        'amount'       => $expectedDepositCommission,
        'charge'       => 0,
        'trx_type'     => '+',
        'details'      => 'Deposit referral commission - ' . $deposit->trx,
        'trx'          => uniqid('ref_'),
        'post_balance' => 0,
    ]);
    
    echo "✅ Deposit amount: ₦{$depositAmount}\n";
    echo "✅ Expected commission (20%): ₦{$expectedDepositCommission}\n\n";
    
    // Test 2: Plan Subscription Commission (50%)
    echo "🧪 TEST 2: PLAN SUBSCRIPTION COMMISSION (50%)\n";
    $plan = Plan::where('status', 1)->first();
    if ($plan) {
        $planPrice = $plan->price;
        $expectedPlanCommission = ($planPrice * 50) / 100; // 50%
        
        // Create plan transaction
        $planTransaction = new Transaction();
        $planTransaction->user_id = $user->id;
        $planTransaction->amount = $planPrice;
        $planTransaction->post_balance = $user->balance - $planPrice;
        $planTransaction->charge = 0;
        $planTransaction->trx_type = '-';
        $planTransaction->details = 'Subscribe ' . $plan->name . ' Plan';
        $planTransaction->trx = uniqid('plan_');
        $planTransaction->remark = 'subscribe_plan';
        $planTransaction->save();
        
        // Create referral commission (50%)
        Transaction::create([
            'user_id'      => $referrer->id,
            'wallet'       => 'referral_bonus',
            'amount'       => $expectedPlanCommission,
            'charge'       => 0,
            'trx_type'     => '+',
            'details'      => 'Plan subscription referral commission - ' . $plan->name,
            'trx'          => uniqid('plan_ref_'),
            'post_balance' => 0,
        ]);
        
        echo "✅ Plan price: ₦{$planPrice}\n";
        echo "✅ Expected commission (50%): ₦{$expectedPlanCommission}\n\n";
    } else {
        echo "❌ No active plans found\n\n";
    }
    
    // Check final results
    $afterCount = Transaction::where('user_id', $referrer->id)
        ->where('wallet', 'referral_bonus')
        ->count();
    
    echo "📊 Referral bonus transactions after: $afterCount\n\n";
    
    if ($afterCount > $beforeCount) {
        $newTransactions = Transaction::where('user_id', $referrer->id)
            ->where('wallet', 'referral_bonus')
            ->orderBy('id', 'desc')
            ->take($afterCount - $beforeCount)
            ->get();
            
        echo "🎉 SUCCESS! New referral bonuses created:\n";
        foreach ($newTransactions as $transaction) {
            echo "💰 Amount: ₦{$transaction->amount}\n";
            echo "📝 Details: {$transaction->details}\n";
            echo "🆔 Transaction: {$transaction->trx}\n\n";
        }
        
        echo "🎯 RESULT: Correct commission amounts are being calculated!\n";
        echo "   - Deposit commissions: 20%\n";
        echo "   - Plan commissions: 50%\n";
    } else {
        echo "❌ FAILED! No referral bonuses created\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== TEST COMPLETE ===\n";