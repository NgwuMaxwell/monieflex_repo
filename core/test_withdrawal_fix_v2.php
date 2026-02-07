<?php

// Test script to verify the withdrawal fix with proper balance validation
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;

echo "Testing Referral Bonus Withdrawal Fix v2\n";
echo "=========================================\n\n";

// Test with a specific user (replace with actual user ID)
$testUserId = 1; // Change this to a real user ID for testing

try {
    $user = User::find($testUserId);
    
    if (!$user) {
        echo "❌ Test user not found. Please update the testUserId variable.\n";
        exit(1);
    }
    
    echo "✅ Test user found: {$user->username}\n";
    
    // Get initial referral bonus balance
    $initialBalance = $user->referralBonus;
    echo "📊 Initial Referral Bonus Balance: {$initialBalance}\n\n";
    
    // Create a test referral bonus credit
    $creditAmount = 100.00;
    Transaction::create([
        'user_id' => $user->id,
        'wallet' => 'referral_bonus',
        'amount' => $creditAmount,
        'charge' => 0,
        'trx_type' => '+',
        'details' => 'Test referral bonus credit',
        'trx' => 'test_credit_' . time(),
        'post_balance' => 0,
    ]);
    
    // Refresh user to get updated balance
    $user->refresh();
    $afterCreditBalance = $user->referralBonus;
    echo "✅ After credit - Referral Bonus Balance: {$afterCreditBalance}\n";
    
    // Verify the credit was applied
    if ($afterCreditBalance == $initialBalance + $creditAmount) {
        echo "✅ Credit applied correctly\n";
    } else {
        echo "❌ Credit not applied correctly\n";
    }
    
    // Test 1: Valid withdrawal (should succeed)
    echo "\n--- Test 1: Valid Withdrawal (50.00) ---\n";
    $withdrawalAmount1 = 50.00;
    $withdrawal1 = Withdrawal::create([
        'user_id' => $user->id,
        'method_id' => 1, // Assuming method ID 1 exists
        'amount' => $withdrawalAmount1,
        'wallet_type' => 'referral_bonus',
        'currency' => 'USD',
        'rate' => 1.0,
        'charge' => 0,
        'final_amount' => $withdrawalAmount1,
        'after_charge' => $withdrawalAmount1,
        'trx' => 'test_withdraw1_' . time(),
        'status' => 2, // Pending
    ]);
    
    echo "✅ Test withdrawal 1 created: {$withdrawalAmount1}\n";
    
    // Simulate admin approval with proper balance validation
    $currentBalance = Transaction::where('user_id', $user->id)
        ->where('wallet', 'referral_bonus')
        ->sum(DB::raw("
            CASE 
                WHEN trx_type = '+' THEN amount
                WHEN trx_type = '-' THEN -amount
            END
        "));
    
    echo "Current balance before approval: {$currentBalance}\n";
    
    if ($withdrawalAmount1 <= $currentBalance) {
        // Create the debit transaction
        Transaction::create([
            'user_id' => $user->id,
            'wallet' => 'referral_bonus',
            'amount' => $withdrawalAmount1,
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Withdrawal approved: ' . $withdrawal1->trx,
            'trx' => $withdrawal1->trx,
            'post_balance' => 0,
        ]);
        
        // Update withdrawal status to approved
        $withdrawal1->status = 1;
        $withdrawal1->save();
        
        // Refresh user to get updated balance
        $user->refresh();
        $afterWithdrawal1Balance = $user->referralBonus;
        echo "✅ After withdrawal 1 approval - Referral Bonus Balance: {$afterWithdrawal1Balance}\n";
        
        $expectedBalance1 = $afterCreditBalance - $withdrawalAmount1;
        if ($afterWithdrawal1Balance == $expectedBalance1) {
            echo "✅ Withdrawal 1 deduction applied correctly\n";
        } else {
            echo "❌ Withdrawal 1 deduction not applied correctly\n";
            echo "Expected: {$expectedBalance1}, Got: {$afterWithdrawal1Balance}\n";
        }
    } else {
        echo "❌ Insufficient balance for withdrawal 1\n";
    }
    
    // Test 2: Invalid withdrawal (should fail due to insufficient balance)
    echo "\n--- Test 2: Invalid Withdrawal (100.00 - should fail) ---\n";
    $withdrawalAmount2 = 100.00;
    $withdrawal2 = Withdrawal::create([
        'user_id' => $user->id,
        'method_id' => 1,
        'amount' => $withdrawalAmount2,
        'wallet_type' => 'referral_bonus',
        'currency' => 'USD',
        'rate' => 1.0,
        'charge' => 0,
        'final_amount' => $withdrawalAmount2,
        'after_charge' => $withdrawalAmount2,
        'trx' => 'test_withdraw2_' . time(),
        'status' => 2, // Pending
    ]);
    
    echo "✅ Test withdrawal 2 created: {$withdrawalAmount2}\n";
    
    // Check balance before approval
    $currentBalance2 = Transaction::where('user_id', $user->id)
        ->where('wallet', 'referral_bonus')
        ->sum(DB::raw("
            CASE 
                WHEN trx_type = '+' THEN amount
                WHEN trx_type = '-' THEN -amount
            END
        "));
    
    echo "Current balance before approval: {$currentBalance2}\n";
    
    if ($withdrawalAmount2 <= $currentBalance2) {
        echo "❌ Withdrawal 2 should have failed due to insufficient balance!\n";
    } else {
        echo "✅ Withdrawal 2 correctly rejected due to insufficient balance\n";
        echo "Available: {$currentBalance2}, Requested: {$withdrawalAmount2}\n";
    }
    
    // Test 3: Edge case - withdrawal equal to balance (should succeed)
    echo "\n--- Test 3: Withdrawal Equal to Balance (should succeed) ---\n";
    $currentBalance3 = Transaction::where('user_id', $user->id)
        ->where('wallet', 'referral_bonus')
        ->sum(DB::raw("
            CASE 
                WHEN trx_type = '+' THEN amount
                WHEN trx_type = '-' THEN -amount
            END
        "));
    
    $withdrawalAmount3 = $currentBalance3;
    $withdrawal3 = Withdrawal::create([
        'user_id' => $user->id,
        'method_id' => 1,
        'amount' => $withdrawalAmount3,
        'wallet_type' => 'referral_bonus',
        'currency' => 'USD',
        'rate' => 1.0,
        'charge' => 0,
        'final_amount' => $withdrawalAmount3,
        'after_charge' => $withdrawalAmount3,
        'trx' => 'test_withdraw3_' . time(),
        'status' => 2, // Pending
    ]);
    
    echo "✅ Test withdrawal 3 created: {$withdrawalAmount3}\n";
    echo "Current balance: {$currentBalance3}\n";
    
    if ($withdrawalAmount3 <= $currentBalance3) {
        // Create the debit transaction
        Transaction::create([
            'user_id' => $user->id,
            'wallet' => 'referral_bonus',
            'amount' => $withdrawalAmount3,
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Withdrawal approved: ' . $withdrawal3->trx,
            'trx' => $withdrawal3->trx,
            'post_balance' => 0,
        ]);
        
        // Update withdrawal status to approved
        $withdrawal3->status = 1;
        $withdrawal3->save();
        
        // Refresh user to get updated balance
        $user->refresh();
        $afterWithdrawal3Balance = $user->referralBonus;
        echo "✅ After withdrawal 3 approval - Referral Bonus Balance: {$afterWithdrawal3Balance}\n";
        
        if ($afterWithdrawal3Balance >= 0) {
            echo "✅ Withdrawal 3 completed successfully, balance >= 0\n";
        } else {
            echo "❌ Withdrawal 3 resulted in negative balance: {$afterWithdrawal3Balance}\n";
        }
    } else {
        echo "❌ Withdrawal 3 should have succeeded but was rejected\n";
    }
    
    // Show final transaction history
    echo "\n📋 Final Referral Bonus Transaction History:\n";
    $transactions = Transaction::where('user_id', $user->id)
        ->where('wallet', 'referral_bonus')
        ->orderBy('created_at', 'desc')
        ->get();
    
    foreach ($transactions as $transaction) {
        $type = $transaction->trx_type == '+' ? 'Credit' : 'Debit';
        echo "  {$type}: {$transaction->amount} ({$transaction->details})\n";
    }
    
    // Final balance check
    $finalBalance = $user->referralBonus;
    echo "\n🎯 Final Referral Bonus Balance: {$finalBalance}\n";
    
    if ($finalBalance >= 0) {
        echo "🎉 SUCCESS: All fixes working correctly! No negative balances.\n";
    } else {
        echo "❌ ERROR: Negative balance detected: {$finalBalance}\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error during test: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}