<?php

// Test script to debug admin balance operations
require_once 'core/bootstrap/app.php';

use App\Models\User;
use App\Models\Transaction;

echo "=== DEBUG ADMIN BALANCE OPERATIONS ===\n\n";

try {
    // Use specific working user
    $user = User::find(65);
    
    if (!$user) {
        echo "❌ Test user not found\n";
        exit;
    }
    
    echo "✅ Found user: {$user->username} (ID: {$user->id})\n\n";
    
    // Test current referral bonus calculation
    echo "🧪 TESTING CURRENT REFERRAL BONUS CALCULATION\n";
    echo "============================================\n\n";
    
    // Get current referral bonus transactions
    $referralTransactions = Transaction::where('user_id', $user->id)
        ->where('wallet', 'referral_bonus')
        ->get();
    
    $totalPositive = $referralTransactions->where('trx_type', '+')->sum('amount');
    $totalNegative = $referralTransactions->where('trx_type', '-')->sum('amount');
    $netBalance = $totalPositive - $totalNegative;
    
    echo "📊 Referral bonus transactions found: {$referralTransactions->count()}\n";
    echo "💰 Total positive transactions: ₦{$totalPositive}\n";
    echo "💰 Total negative transactions: ₦{$totalNegative}\n";
    echo "💰 Net balance: ₦{$netBalance}\n\n";
    
    // Test User model accessor
    $modelBalance = $user->referral_bonus;
    echo "👤 Referral bonus from User model: ₦{$modelBalance}\n\n";
    
    // Test balance check for subtraction
    echo "🧪 TESTING BALANCE CHECK FOR SUBTRACTION\n";
    echo "=======================================\n\n";
    
    $amountToSubtract = 1000;
    echo "Amount to subtract: ₦{$amountToSubtract}\n";
    echo "Current balance: ₦{$netBalance}\n";
    
    if ($amountToSubtract > $netBalance) {
        echo "❌ INSUFFICIENT BALANCE - Subtraction should be blocked\n";
    } else {
        echo "✅ SUFFICIENT BALANCE - Subtraction should be allowed\n";
    }
    
    echo "\n🧪 TESTING ADMIN SUBTRACTION LOGIC\n";
    echo "==================================\n\n";
    
    // Simulate admin subtraction
    echo "Creating negative transaction for ₦{$amountToSubtract}...\n";
    
    $transaction = Transaction::create([
        'user_id'      => $user->id,
        'wallet'       => 'referral_bonus',
        'amount'       => $amountToSubtract,
        'charge'       => 0,
        'trx_type'     => '-',
        'details'      => 'Admin subtraction test',
        'trx'          => uniqid('admin_'),
        'post_balance' => 0,
    ]);
    
    echo "✅ Created negative transaction: {$transaction->trx}\n";
    
    // Test updated balance
    $newReferralTransactions = Transaction::where('user_id', $user->id)
        ->where('wallet', 'referral_bonus')
        ->get();
    
    $newTotalPositive = $newReferralTransactions->where('trx_type', '+')->sum('amount');
    $newTotalNegative = $newReferralTransactions->where('trx_type', '-')->sum('amount');
    $newNetBalance = $newTotalPositive - $newTotalNegative;
    
    echo "📊 After subtraction:\n";
    echo "💰 Total positive transactions: ₦{$newTotalPositive}\n";
    echo "💰 Total negative transactions: ₦{$newTotalNegative}\n";
    echo "💰 New net balance: ₦{$newNetBalance}\n\n";
    
    // Test User model accessor after subtraction
    $newModelBalance = $user->fresh()->referral_bonus;
    echo "👤 Referral bonus from User model after subtraction: ₦{$newModelBalance}\n\n";
    
    if (abs($newNetBalance - $newModelBalance) < 0.01) {
        echo "🎉 SUCCESS! Admin subtraction is working correctly!\n";
        echo "   - Net balance: ₦{$newNetBalance}\n";
        echo "   - Model accessor: ₦{$newModelBalance}\n";
        echo "   - Match: ✅\n";
    } else {
        echo "❌ FAILED! Admin subtraction is not working correctly!\n";
        echo "   - Net balance: ₦{$newNetBalance}\n";
        echo "   - Model accessor: ₦{$newModelBalance}\n";
        echo "   - Match: ❌\n";
    }
    
    // Show all referral bonus transactions
    echo "\n📋 All referral bonus transactions:\n";
    foreach ($newReferralTransactions as $transaction) {
        $sign = $transaction->trx_type === '+' ? '+' : '-';
        echo "   {$sign}₦{$transaction->amount} ({$transaction->details})\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "❌ File: " . $e->getFile() . "\n";
    echo "❌ Line: " . $e->getLine() . "\n";
}

echo "\n=== DEBUG COMPLETE ===\n";