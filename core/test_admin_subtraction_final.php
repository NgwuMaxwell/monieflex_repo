<?php

// Final test to verify admin subtraction works and dashboard shows correct balance
require_once 'core/bootstrap/app.php';

use App\Models\User;
use App\Models\Transaction;

echo "=== FINAL ADMIN SUBTRACTION TEST ===\n\n";

try {
    // Use specific working user
    $user = User::find(65);
    
    if (!$user) {
        echo "❌ Test user not found\n";
        exit;
    }
    
    echo "✅ Found user: {$user->username} (ID: {$user->id})\n\n";
    
    // Get current referral bonus from User model (dashboard calculation)
    $currentBalance = $user->referral_bonus;
    echo "📊 Current referral bonus (dashboard calculation): ₦{$currentBalance}\n\n";
    
    // Get detailed transaction breakdown
    $positiveTransactions = Transaction::where('user_id', $user->id)
        ->where('wallet', 'referral_bonus')
        ->where('trx_type', '+')
        ->sum('amount');
    
    $negativeTransactions = Transaction::where('user_id', $user->id)
        ->where('wallet', 'referral_bonus')
        ->where('trx_type', '-')
        ->sum('amount');
    
    echo "📊 Transaction breakdown:\n";
    echo "   Positive transactions: ₦{$positiveTransactions}\n";
    echo "   Negative transactions: ₦{$negativeTransactions}\n";
    echo "   Net balance: ₦" . ($positiveTransactions - $negativeTransactions) . "\n\n";
    
    // Test admin subtraction of 1000
    echo "🧪 Simulating admin subtraction of ₦1000...\n";
    
    $transaction = Transaction::create([
        'user_id'      => $user->id,
        'wallet'       => 'referral_bonus',
        'amount'       => 1000,
        'charge'       => 0,
        'trx_type'     => '-',
        'details'      => 'Admin subtraction test',
        'trx'          => uniqid('admin_'),
        'post_balance' => 0,
    ]);
    
    echo "✅ Created negative transaction: {$transaction->trx}\n";
    
    // Get updated balance from User model (dashboard calculation)
    $updatedUser = User::find($user->id);
    $newBalance = $updatedUser->referral_bonus;
    
    echo "\n📊 After admin subtraction:\n";
    echo "   New referral bonus (dashboard calculation): ₦{$newBalance}\n";
    echo "   Expected decrease: ₦1000\n";
    echo "   Actual decrease: ₦" . ($currentBalance - $newBalance) . "\n\n";
    
    // Get updated transaction breakdown
    $newPositiveTransactions = Transaction::where('user_id', $user->id)
        ->where('wallet', 'referral_bonus')
        ->where('trx_type', '+')
        ->sum('amount');
    
    $newNegativeTransactions = Transaction::where('user_id', $user->id)
        ->where('wallet', 'referral_bonus')
        ->where('trx_type', '-')
        ->sum('amount');
    
    echo "📊 Updated transaction breakdown:\n";
    echo "   Positive transactions: ₦{$newPositiveTransactions}\n";
    echo "   Negative transactions: ₦{$newNegativeTransactions}\n";
    echo "   Net balance: ₦" . ($newPositiveTransactions - $newNegativeTransactions) . "\n\n";
    
    if ($currentBalance - $newBalance == 1000) {
        echo "🎉 SUCCESS! Admin subtraction is working correctly!\n";
        echo "   - Old balance: ₦{$currentBalance}\n";
        echo "   - New balance: ₦{$newBalance}\n";
        echo "   - Decrease: ₦" . ($currentBalance - $newBalance) . "\n";
        echo "   - Expected: ₦1000\n";
        echo "   - Match: ✅\n";
        echo "\n🎯 The dashboard WILL show the correct updated balance!\n";
    } else {
        echo "❌ FAILED! Admin subtraction is not working correctly!\n";
        echo "   - Old balance: ₦{$currentBalance}\n";
        echo "   - New balance: ₦{$newBalance}\n";
        echo "   - Decrease: ₦" . ($currentBalance - $newBalance) . "\n";
        echo "   - Expected: ₦1000\n";
        echo "   - Match: ❌\n";
    }
    
    // Show all referral bonus transactions
    echo "\n📋 All referral bonus transactions:\n";
    $allTransactions = Transaction::where('user_id', $user->id)
        ->where('wallet', 'referral_bonus')
        ->orderBy('created_at', 'desc')
        ->get();
    
    foreach ($allTransactions as $transaction) {
        $sign = $transaction->trx_type === '+' ? '+' : '-';
        echo "   {$sign}₦{$transaction->amount} ({$transaction->details}) - {$transaction->created_at}\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "❌ File: " . $e->getFile() . "\n";
    echo "❌ Line: " . $e->getLine() . "\n";
}

echo "\n=== TEST COMPLETE ===\n";