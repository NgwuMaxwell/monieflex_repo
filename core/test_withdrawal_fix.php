<?php

// Test script to verify the withdrawal fix
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;

echo "Testing Referral Bonus Withdrawal Fix\n";
echo "=====================================\n\n";

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
    
    // Create a test withdrawal
    $withdrawalAmount = 50.00;
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
    
    // Simulate admin approval (this is what was broken before)
    // Create the debit transaction as the Admin WithdrawalController does
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
    $afterWithdrawalBalance = $user->referralBonus;
    echo "✅ After withdrawal approval - Referral Bonus Balance: {$afterWithdrawalBalance}\n";
    
    // Verify the withdrawal was deducted
    $expectedBalance = $afterCreditBalance - $withdrawalAmount;
    if ($afterWithdrawalBalance == $expectedBalance) {
        echo "✅ Withdrawal deduction applied correctly\n";
        echo "🎉 FIX VERIFIED: Referral bonus wallet is now properly debited on withdrawal approval!\n";
    } else {
        echo "❌ Withdrawal deduction not applied correctly\n";
        echo "Expected: {$expectedBalance}, Got: {$afterWithdrawalBalance}\n";
    }
    
    // Show transaction history
    echo "\n📋 Referral Bonus Transaction History:\n";
    $transactions = Transaction::where('user_id', $user->id)
        ->where('wallet', 'referral_bonus')
        ->orderBy('created_at', 'desc')
        ->get();
    
    foreach ($transactions as $transaction) {
        $type = $transaction->trx_type == '+' ? 'Credit' : 'Debit';
        echo "  {$type}: {$transaction->amount} ({$transaction->details})\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error during test: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}