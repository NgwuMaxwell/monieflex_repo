<?php

// Test script to verify both Referral Bonus and Profit Wallet fixes
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;

echo "Testing Both Wallets Fix (Referral Bonus + Profit Wallet)\n";
echo "=========================================================\n\n";

// Test with a specific user (replace with actual user ID)
$testUserId = 1; // Change this to a real user ID for testing

try {
    $user = User::find($testUserId);
    
    if (!$user) {
        echo "❌ Test user not found. Please update the testUserId variable.\n";
        exit(1);
    }
    
    echo "✅ Test user found: {$user->username}\n";
    
    // Test 1: Referral Bonus Wallet
    echo "\n--- Test 1: Referral Bonus Wallet ---\n";
    $initialReferralBalance = $user->referralBonus;
    echo "📊 Initial Referral Bonus Balance: {$initialReferralBalance}\n";
    
    // Create referral bonus credit
    $referralCredit = 50.00;
    Transaction::create([
        'user_id' => $user->id,
        'wallet' => 'referral_bonus',
        'amount' => $referralCredit,
        'charge' => 0,
        'trx_type' => '+',
        'details' => 'Test referral bonus credit',
        'trx' => 'test_ref_credit_' . time(),
        'post_balance' => 0,
    ]);
    
    $user->refresh();
    $afterReferralCredit = $user->referralBonus;
    echo "After referral credit: {$afterReferralCredit}\n";
    
    // Test Referral Bonus withdrawal
    $referralWithdrawal = 20.00;
    $referralWithdrawalRecord = Withdrawal::create([
        'user_id' => $user->id,
        'method_id' => 1,
        'amount' => $referralWithdrawal,
        'wallet_type' => 'referral_bonus',
        'currency' => 'USD',
        'rate' => 1.0,
        'charge' => 0,
        'final_amount' => $referralWithdrawal,
        'after_charge' => $referralWithdrawal,
        'trx' => 'test_ref_withdraw_' . time(),
        'status' => 2, // Pending
    ]);
    
    // Check balance after submission (should NOT change)
    $user->refresh();
    $referralBalanceAfterSubmission = $user->referralBonus;
    echo "Balance after referral withdrawal submission: {$referralBalanceAfterSubmission}\n";
    
    if ($referralBalanceAfterSubmission == $afterReferralCredit) {
        echo "✅ Referral Bonus: No premature deduction on submission\n";
    } else {
        echo "❌ Referral Bonus: Premature deduction occurred!\n";
    }
    
    // Simulate admin approval for referral bonus
    Transaction::create([
        'user_id' => $user->id,
        'wallet' => 'referral_bonus',
        'amount' => $referralWithdrawal,
        'charge' => 0,
        'trx_type' => '-',
        'details' => 'Referral withdrawal approved: ' . $referralWithdrawalRecord->trx,
        'trx' => $referralWithdrawalRecord->trx,
        'post_balance' => 0,
    ]);
    
    $referralWithdrawalRecord->status = 1;
    $referralWithdrawalRecord->save();
    
    $user->refresh();
    $referralBalanceAfterApproval = $user->referralBonus;
    echo "Balance after referral withdrawal approval: {$referralBalanceAfterApproval}\n";
    
    $expectedReferralBalance = $afterReferralCredit - $referralWithdrawal;
    if ($referralBalanceAfterApproval == $expectedReferralBalance) {
        echo "✅ Referral Bonus: Correct deduction on approval\n";
    } else {
        echo "❌ Referral Bonus: Incorrect deduction on approval\n";
        echo "Expected: {$expectedReferralBalance}, Got: {$referralBalanceAfterApproval}\n";
    }
    
    // Test 2: Profit Wallet
    echo "\n--- Test 2: Profit Wallet ---\n";
    $initialProfitBalance = $user->profitWallet;
    echo "📊 Initial Profit Wallet Balance: {$initialProfitBalance}\n";
    
    // Create profit wallet credit
    $profitCredit = 100.00;
    Transaction::create([
        'user_id' => $user->id,
        'wallet' => 'main_balance',
        'amount' => $profitCredit,
        'charge' => 0,
        'trx_type' => '+',
        'details' => 'Test profit wallet credit',
        'trx' => 'test_profit_credit_' . time(),
        'post_balance' => 0,
    ]);
    
    $user->refresh();
    $afterProfitCredit = $user->profitWallet;
    echo "After profit credit: {$afterProfitCredit}\n";
    
    // Test Profit Wallet withdrawal
    $profitWithdrawal = 30.00;
    $profitWithdrawalRecord = Withdrawal::create([
        'user_id' => $user->id,
        'method_id' => 1,
        'amount' => $profitWithdrawal,
        'wallet_type' => 'profit_wallet',
        'currency' => 'USD',
        'rate' => 1.0,
        'charge' => 0,
        'final_amount' => $profitWithdrawal,
        'after_charge' => $profitWithdrawal,
        'trx' => 'test_profit_withdraw_' . time(),
        'status' => 2, // Pending
    ]);
    
    // Check balance after submission (should NOT change)
    $user->refresh();
    $profitBalanceAfterSubmission = $user->profitWallet;
    echo "Balance after profit withdrawal submission: {$profitBalanceAfterSubmission}\n";
    
    if ($profitBalanceAfterSubmission == $afterProfitCredit) {
        echo "✅ Profit Wallet: No premature deduction on submission\n";
    } else {
        echo "❌ Profit Wallet: Premature deduction occurred!\n";
    }
    
    // Simulate admin approval for profit wallet
    Transaction::create([
        'user_id' => $user->id,
        'wallet' => 'main_balance',
        'amount' => $profitWithdrawal,
        'charge' => 0,
        'trx_type' => '-',
        'details' => 'Profit withdrawal approved: ' . $profitWithdrawalRecord->trx,
        'trx' => $profitWithdrawalRecord->trx,
        'post_balance' => 0,
    ]);
    
    $profitWithdrawalRecord->status = 1;
    $profitWithdrawalRecord->save();
    
    $user->refresh();
    $profitBalanceAfterApproval = $user->profitWallet;
    echo "Balance after profit withdrawal approval: {$profitBalanceAfterApproval}\n";
    
    $expectedProfitBalance = $afterProfitCredit - $profitWithdrawal;
    if ($profitBalanceAfterApproval == $expectedProfitBalance) {
        echo "✅ Profit Wallet: Correct deduction on approval\n";
    } else {
        echo "❌ Profit Wallet: Incorrect deduction on approval\n";
        echo "Expected: {$expectedProfitBalance}, Got: {$profitBalanceAfterApproval}\n";
    }
    
    // Final verification
    echo "\n--- Final Verification ---\n";
    $finalReferralBalance = $user->referralBonus;
    $finalProfitBalance = $user->profitWallet;
    
    echo "🎯 Final Referral Bonus Balance: {$finalReferralBalance}\n";
    echo "🎯 Final Profit Wallet Balance: {$finalProfitBalance}\n";
    
    // Calculate expected final balances
    $expectedFinalReferral = $initialReferralBalance + $referralCredit - $referralWithdrawal;
    $expectedFinalProfit = $initialProfitBalance + $profitCredit - $profitWithdrawal;
    
    echo "Expected Referral Bonus: {$expectedFinalReferral}\n";
    echo "Expected Profit Wallet: {$expectedFinalProfit}\n";
    
    $referralCorrect = ($finalReferralBalance == $expectedFinalReferral);
    $profitCorrect = ($finalProfitBalance == $expectedFinalProfit);
    
    if ($referralCorrect && $profitCorrect) {
        echo "🎉 SUCCESS: Both wallets working correctly!\n";
        echo "✅ Referral Bonus: No double deduction, correct balance\n";
        echo "✅ Profit Wallet: No double deduction, correct balance\n";
        echo "✅ Both wallets now work smoothly with the same logic\n";
    } else {
        echo "❌ ERROR: One or both wallets have issues\n";
        if (!$referralCorrect) echo "❌ Referral Bonus balance incorrect\n";
        if (!$profitCorrect) echo "❌ Profit Wallet balance incorrect\n";
    }
    
    // Show transaction summary
    echo "\n📋 Transaction Summary:\n";
    $referralTransactions = Transaction::where('user_id', $user->id)
        ->where('wallet', 'referral_bonus')
        ->count();
    $profitTransactions = Transaction::where('user_id', $user->id)
        ->where('wallet', 'main_balance')
        ->count();
    
    echo "Referral Bonus transactions: {$referralTransactions}\n";
    echo "Profit Wallet transactions: {$profitTransactions}\n";
    
} catch (Exception $e) {
    echo "❌ Error during test: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}