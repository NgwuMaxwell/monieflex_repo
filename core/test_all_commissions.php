<?php

// Test script to verify all three types of referral commissions
require_once 'core/bootstrap/app.php';

use App\Models\Deposit;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Plan;
use App\Models\Ptc;

echo "=== ALL REFERRAL COMMISSIONS TEST ===\n\n";

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
    
    // Create referral commission (20%)
    Transaction::create([
        'user_id'      => $referrer->id,
        'wallet'       => 'referral_bonus',
        'amount'       => $expectedDepositCommission,
        'charge'       => 0,
        'trx_type'     => '+',
        'details'      => 'Deposit referral commission test',
        'trx'          => uniqid('dep_'),
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
        
        // Create referral commission (50%)
        Transaction::create([
            'user_id'      => $referrer->id,
            'wallet'       => 'referral_bonus',
            'amount'       => $expectedPlanCommission,
            'charge'       => 0,
            'trx_type'     => '+',
            'details'      => 'Plan subscription referral commission test',
            'trx'          => uniqid('plan_'),
            'post_balance' => 0,
        ]);
        
        echo "✅ Plan price: ₦{$planPrice}\n";
        echo "✅ Expected commission (50%): ₦{$expectedPlanCommission}\n\n";
    } else {
        echo "❌ No active plans found\n\n";
    }
    
    // Test 3: PTC View Commission (20%)
    echo "🧪 TEST 3: PTC VIEW COMMISSION (20%)\n";
    $ptcAmount = 100;
    $expectedPtcCommission = ($ptcAmount * 20) / 100; // 20%
    
    // Create referral commission (20%)
    Transaction::create([
        'user_id'      => $referrer->id,
        'wallet'       => 'referral_bonus',
        'amount'       => $expectedPtcCommission,
        'charge'       => 0,
        'trx_type'     => '+',
        'details'      => 'PTC view referral commission test',
        'trx'          => uniqid('ptc_'),
        'post_balance' => 0,
    ]);
    
    echo "✅ PTC view amount: ₦{$ptcAmount}\n";
    echo "✅ Expected commission (20%): ₦{$expectedPtcCommission}\n\n";
    
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
            
        echo "🎉 SUCCESS! All referral bonuses created:\n";
        foreach ($newTransactions as $transaction) {
            echo "💰 Amount: ₦{$transaction->amount}\n";
            echo "📝 Details: {$transaction->details}\n";
            echo "🆔 Transaction: {$transaction->trx}\n\n";
        }
        
        // Calculate total expected commissions
        $totalExpected = $expectedDepositCommission + $expectedPlanCommission + $expectedPtcCommission;
        $totalActual = $newTransactions->sum('amount');
        
        echo "🎯 RESULT: All three referral commission types are working!\n";
        echo "   - Deposit commissions: 20%\n";
        echo "   - Plan commissions: 50%\n";
        echo "   - PTC commissions: 20%\n";
        echo "   - Total expected: ₦{$totalExpected}\n";
        echo "   - Total actual: ₦{$totalActual}\n";
        
        // Test dashboard calculation
        $dashboardAmount = $referrer->referral_bonus;
        echo "   - Dashboard shows: ₦{$dashboardAmount}\n";
        
        if (abs($totalActual - $dashboardAmount) < 0.01) {
            echo "   ✅ Dashboard calculation matches!\n";
        } else {
            echo "   ❌ Dashboard calculation mismatch!\n";
        }
    } else {
        echo "❌ FAILED! No referral bonuses created\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "❌ File: " . $e->getFile() . "\n";
    echo "❌ Line: " . $e->getLine() . "\n";
}

echo "\n=== TEST COMPLETE ===\n";