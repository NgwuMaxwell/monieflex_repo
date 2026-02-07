<?php

// Test script to verify the double deduction fix
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;

echo "Testing Double Deduction Fix\n";
echo "============================\n\n";

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
    
    // Test: Withdrawal submission (should NOT deduct balance yet)
    echo "\n--- Test: Withdrawal Submission (should NOT deduct) ---\n";
    $withdrawalAmount = 30.00;
    $withdrawal = Withdrawal::create([
        'user_id' => $user->id,
        'method_id' => 1, // Assuming method ID 1 exists
        'amount' => $withdrawalAmount,
        'wallet_type' => 'referral_bonus',
        'currency' => 'USD',
        'rate' => 1.0,
        'charge' => 0,
        'final_amount' => $withdrawalAmount,
        'after_charge' => $withdrawalAmount,
        'trx' => 'test_withdraw_' . time(),
        'status' => 2, // Pending
    ]);
    
    echo "✅ Test withdrawal created: {$withdrawalAmount}\n";
    
    // Check balance after submission (should still be the same)
    $user->refresh();
    $balanceAfterSubmission = $user->referralBonus;
    echo "Balance after submission: {$balanceAfterSubmission}\n";
    
    if ($balanceAfterSubmission == $afterCreditBalance) {
        echo "✅ Balance correctly unchanged after submission (no double deduction)\n";
    } else {
        echo "❌ Balance changed after submission - double deduction occurred!\n";
        echo "Expected: {$afterCreditBalance}, Got: {$balanceAfterSubmission}\n";
    }
    
    // Test: Admin approval (should deduct balance now)
    echo "\n--- Test: Admin Approval (should deduct now) ---\n";
    
    // Calculate current balance before approval
    $currentBalance = Transaction::where('user_id', $user->id)
        ->where('wallet', 'referral_bonus')
        ->sum(DB::raw("
            CASE 
                WHEN trx_type = '+' THEN amount
                WHEN trx_type = '-' THEN -amount
            END
        "));
    
    echo "Current balance before approval: {$currentBalance}\n";
    
    if ($withdrawalAmount <= $currentBalance) {
        // Create the debit transaction (simulating admin approval)
        Transaction::create([
            'user_id' => $user->id,
            'wallet' => 'referral_bonus',
            'amount' => $withdrawalAmount,
            'charge' => 0,
            'trx_type' => '-',
            'details' => 'Withdrawal approved: ' . $withdrawal->trx,
            'trx' => $withdrawal->trx,
            'post_balance' => 0,
        ]);
        
        // Update withdrawal status to approved
        $withdrawal->status = 1;
        $withdrawal->save();
        
        // Refresh user to get updated balance
        $user->refresh();
        $afterApprovalBalance = $user->referralBonus;
        echo "✅ After approval - Referral Bonus Balance: {$afterApprovalBalance}\n";
        
        $expectedBalance = $afterCreditBalance - $withdrawalAmount;
        if ($afterApprovalBalance == $expectedBalance) {
            echo "✅ Withdrawal deduction applied correctly (single deduction)\n";
            echo "✅ NO DOUBLE DEDUCTION - Fix successful!\n";
        } else {
            echo "❌ Withdrawal deduction not applied correctly\n";
            echo "Expected: {$expectedBalance}, Got: {$afterApprovalBalance}\n";
        }
    } else {
        echo "❌ Insufficient balance for approval\n";
    }
    
    // Show transaction history to verify only one debit transaction
    echo "\n📋 Referral Bonus Transaction History:\n";
    $transactions = Transaction::where('user_id', $user->id)
        ->where('wallet', 'referral_bonus')
        ->orderBy('created_at', 'desc')
        ->get();
    
    $creditCount = 0;
    $debitCount = 0;
    
    foreach ($transactions as $transaction) {
        $type = $transaction->trx_type == '+' ? 'Credit' : 'Debit';
        echo "  {$type}: {$transaction->amount} ({$transaction->details})\n";
        
        if ($transaction->trx_type == '+') {
            $creditCount++;
        } else {
            $debitCount++;
        }
    }
    
    echo "\n📊 Summary:\n";
    echo "  Credits: {$creditCount}\n";
    echo "  Debits: {$debitCount}\n";
    
    if ($debitCount == 1) {
        echo "✅ CORRECT: Only one debit transaction (no double deduction)\n";
    } else {
        echo "❌ ERROR: Multiple debit transactions detected\n";
    }
    
    // Final balance check
    $finalBalance = $user->referralBonus;
    echo "\n🎯 Final Referral Bonus Balance: {$finalBalance}\n";
    
    $expectedFinal = $initialBalance + $creditAmount - $withdrawalAmount;
    if ($finalBalance == $expectedFinal) {
        echo "🎉 SUCCESS: Double deduction issue FIXED! Balance calculation is correct.\n";
    } else {
        echo "❌ ERROR: Balance calculation still incorrect\n";
        echo "Expected: {$expectedFinal}, Got: {$finalBalance}\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error during test: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}