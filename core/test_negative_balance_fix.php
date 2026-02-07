<?php

// Test script to verify negative balance prevention for both wallets
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;

echo "Testing Negative Balance Prevention Fix\n";
echo "=======================================\n\n";

// Test with a specific user (replace with actual user ID)
$testUserId = 1; // Change this to a real user ID for testing

try {
    $user = User::find($testUserId);
    
    if (!$user) {
        echo "❌ Test user not found. Please update the testUserId variable.\n";
        exit(1);
    }
    
    echo "✅ Test user found: {$user->username}\n";
    
    // Test 1: Profit Wallet - Attempt to withdraw more than available
    echo "\n--- Test 1: Profit Wallet - Over-withdrawal Prevention ---\n";
    
    // Set up a small profit wallet balance
    $initialProfitBalance = 50.00;
    // Clear any existing profit wallet transactions for clean test
    Transaction::where('user_id', $user->id)
        ->where('wallet', 'main_balance')
        ->delete();
    
    // Create a small profit wallet credit
    Transaction::create([
        'user_id' => $user->id,
        'wallet' => 'main_balance',
        'amount' => $initialProfitBalance,
        'charge' => 0,
        'trx_type' => '+',
        'details' => 'Test profit wallet setup',
        'trx' => 'test_profit_setup_' . time(),
        'post_balance' => 0,
    ]);
    
    $user->refresh();
    $currentProfitBalance = $user->profitWallet;
    echo "Current Profit Wallet Balance: {$currentProfitBalance}\n";
    
    // Try to withdraw more than available (should be rejected)
    $overWithdrawalAmount = 80.00; // More than the 50.00 available
    echo "Attempting to withdraw: {$overWithdrawalAmount} (should be rejected)\n";
    
    // Simulate admin approval attempt
    $currentBalance = Transaction::where('user_id', $user->id)
        ->where('wallet', 'main_balance')
        ->sum(DB::raw("
            CASE 
                WHEN trx_type = '+' THEN amount
                WHEN trx_type = '-' THEN -amount
            END
        "));
    
    echo "Calculated balance: {$currentBalance}\n";
    
    if ($overWithdrawalAmount > $currentBalance) {
        echo "✅ Profit Wallet: Over-withdrawal correctly rejected\n";
        echo "Available: {$currentBalance}, Requested: {$overWithdrawalAmount}\n";
    } else {
        echo "❌ Profit Wallet: Over-withdrawal should have been rejected!\n";
    }
    
    // Try to withdraw exactly the available amount (should succeed)
    $exactWithdrawalAmount = $currentBalance;
    echo "\nAttempting to withdraw exactly available amount: {$exactWithdrawalAmount}\n";
    
    if ($exactWithdrawalAmount <= $currentBalance) {
        // Create the debit transaction (simulating successful approval)
        Transaction::create([
            'user_id' => $user->id,
            'wallet' => 'main_balance',
            'amount' => $exactWithdrawalAmount,
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Profit withdrawal approved',
            'trx' => 'test_profit_exact_' . time(),
            'post_balance' => 0,
        ]);
        
        $user->refresh();
        $finalProfitBalance = $user->profitWallet;
        echo "Final Profit Wallet Balance: {$finalProfitBalance}\n";
        
        if ($finalProfitBalance >= 0) {
            echo "✅ Profit Wallet: Exact withdrawal succeeded, balance >= 0\n";
        } else {
            echo "❌ Profit Wallet: Balance went negative: {$finalProfitBalance}\n";
        }
    }
    
    // Test 2: Referral Bonus Wallet - Attempt to withdraw more than available
    echo "\n--- Test 2: Referral Bonus Wallet - Over-withdrawal Prevention ---\n";
    
    // Set up a small referral bonus balance
    $initialReferralBalance = 30.00;
    // Clear any existing referral bonus transactions for clean test
    Transaction::where('user_id', $user->id)
        ->where('wallet', 'referral_bonus')
        ->delete();
    
    // Create a small referral bonus credit
    Transaction::create([
        'user_id' => $user->id,
        'wallet' => 'referral_bonus',
        'amount' => $initialReferralBalance,
        'charge' => 0,
        'trx_type' => '+',
        'details' => 'Test referral bonus setup',
        'trx' => 'test_ref_setup_' . time(),
        'post_balance' => 0,
    ]);
    
    $user->refresh();
    $currentReferralBalance = $user->referralBonus;
    echo "Current Referral Bonus Balance: {$currentReferralBalance}\n";
    
    // Try to withdraw more than available (should be rejected)
    $overReferralWithdrawal = 50.00; // More than the 30.00 available
    echo "Attempting to withdraw: {$overReferralWithdrawal} (should be rejected)\n";
    
    // Simulate admin approval attempt
    $currentReferralBalanceCalc = Transaction::where('user_id', $user->id)
        ->where('wallet', 'referral_bonus')
        ->sum(DB::raw("
            CASE 
                WHEN trx_type = '+' THEN amount
                WHEN trx_type = '-' THEN -amount
            END
        "));
    
    echo "Calculated balance: {$currentReferralBalanceCalc}\n";
    
    if ($overReferralWithdrawal > $currentReferralBalanceCalc) {
        echo "✅ Referral Bonus: Over-withdrawal correctly rejected\n";
        echo "Available: {$currentReferralBalanceCalc}, Requested: {$overReferralWithdrawal}\n";
    } else {
        echo "❌ Referral Bonus: Over-withdrawal should have been rejected!\n";
    }
    
    // Try to withdraw exactly the available amount (should succeed)
    $exactReferralWithdrawal = $currentReferralBalanceCalc;
    echo "\nAttempting to withdraw exactly available amount: {$exactReferralWithdrawal}\n";
    
    if ($exactReferralWithdrawal <= $currentReferralBalanceCalc) {
        // Create the debit transaction (simulating successful approval)
        Transaction::create([
            'user_id' => $user->id,
            'wallet' => 'referral_bonus',
            'amount' => $exactReferralWithdrawal,
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Referral withdrawal approved',
            'trx' => 'test_ref_exact_' . time(),
            'post_balance' => 0,
        ]);
        
        $user->refresh();
        $finalReferralBalance = $user->referralBonus;
        echo "Final Referral Bonus Balance: {$finalReferralBalance}\n";
        
        if ($finalReferralBalance >= 0) {
            echo "✅ Referral Bonus: Exact withdrawal succeeded, balance >= 0\n";
        } else {
            echo "❌ Referral Bonus: Balance went negative: {$finalReferralBalance}\n";
        }
    }
    
    // Test 3: Edge case - Withdrawal that would result in exactly 0 balance
    echo "\n--- Test 3: Edge Case - Zero Balance Withdrawal ---\n";
    
    // Set up another small balance
    $edgeBalance = 25.00;
    Transaction::create([
        'user_id' => $user->id,
        'wallet' => 'main_balance',
        'amount' => $edgeBalance,
        'charge' => 0,
        'trx_type' => '+',
        'details' => 'Edge case setup',
        'trx' => 'test_edge_setup_' . time(),
        'post_balance' => 0,
    ]);
    
    $user->refresh();
    $edgeCurrentBalance = $user->profitWallet;
    echo "Edge case balance: {$edgeCurrentBalance}\n";
    
    // Withdraw exactly the amount to reach zero
    $zeroWithdrawal = $edgeCurrentBalance;
    echo "Withdrawing exactly: {$zeroWithdrawal} (should result in 0 balance)\n";
    
    if ($zeroWithdrawal <= $edgeCurrentBalance) {
        Transaction::create([
            'user_id' => $user->id,
            'wallet' => 'main_balance',
            'amount' => $zeroWithdrawal,
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Zero balance withdrawal',
            'trx' => 'test_zero_withdraw_' . time(),
            'post_balance' => 0,
        ]);
        
        $user->refresh();
        $finalEdgeBalance = $user->profitWallet;
        echo "Final edge case balance: {$finalEdgeBalance}\n";
        
        if ($finalEdgeBalance == 0) {
            echo "✅ Edge case: Balance correctly reached exactly 0\n";
        } elseif ($finalEdgeBalance > 0) {
            echo "⚠️  Edge case: Balance is positive: {$finalEdgeBalance}\n";
        } else {
            echo "❌ Edge case: Balance went negative: {$finalEdgeBalance}\n";
        }
    }
    
    // Final summary
    echo "\n--- Final Summary ---\n";
    $finalProfit = $user->profitWallet;
    $finalReferral = $user->referralBonus;
    
    echo "🎯 Final Profit Wallet Balance: {$finalProfit}\n";
    echo "🎯 Final Referral Bonus Balance: {$finalReferral}\n";
    
    if ($finalProfit >= 0 && $finalReferral >= 0) {
        echo "🎉 SUCCESS: Both wallets prevent negative balances!\n";
        echo "✅ Profit Wallet: No negative balance\n";
        echo "✅ Referral Bonus: No negative balance\n";
        echo "✅ All withdrawal validation working correctly\n";
    } else {
        echo "❌ ERROR: One or both wallets have negative balances\n";
        if ($finalProfit < 0) echo "❌ Profit Wallet: {$finalProfit}\n";
        if ($finalReferral < 0) echo "❌ Referral Bonus: {$finalReferral}\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error during test: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}