<?php

// Test script to verify dashboard referral bonus calculation
require_once 'core/bootstrap/app.php';

use App\Models\User;
use App\Models\Transaction;

echo "=== DASHBOARD REFERRAL BONUS CALCULATION TEST ===\n\n";

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
    
    // Test the dashboard calculation for the referrer
    echo "🧪 TESTING REFERRER DASHBOARD CALCULATION\n";
    echo "==========================================\n\n";
    
    // Get referral bonus transactions for the referrer
    $referralTransactions = Transaction::where('user_id', $referrer->id)
        ->where('wallet', 'referral_bonus')
        ->where('trx_type', '+')
        ->get();
    
    $totalFromTransactions = $referralTransactions->sum('amount');
    
    echo "📊 Referral bonus transactions found: {$referralTransactions->count()}\n";
    echo "💰 Total from transactions table: ₦{$totalFromTransactions}\n\n";
    
    // Test the User model accessor
    $referralBonusFromModel = $referrer->referral_bonus;
    
    echo "👤 Referral bonus from User model: ₦{$referralBonusFromModel}\n\n";
    
    // Verify they match
    if (abs($totalFromTransactions - $referralBonusFromModel) < 0.01) {
        echo "🎉 SUCCESS! Dashboard calculation is working correctly!\n";
        echo "   - Transactions total: ₦{$totalFromTransactions}\n";
        echo "   - Model accessor: ₦{$referralBonusFromModel}\n";
        echo "   - Match: ✅\n\n";
        
        echo "🎯 RESULT: Dashboard will now show the correct Referral Bonus amount!\n";
        
        // Show individual transactions
        if ($referralTransactions->count() > 0) {
            echo "\n📋 Individual referral bonus transactions:\n";
            foreach ($referralTransactions as $transaction) {
                echo "   - ₦{$transaction->amount} ({$transaction->details})\n";
            }
        }
    } else {
        echo "❌ FAILED! Dashboard calculation mismatch!\n";
        echo "   - Transactions total: ₦{$totalFromTransactions}\n";
        echo "   - Model accessor: ₦{$referralBonusFromModel}\n";
        echo "   - Match: ❌\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "❌ File: " . $e->getFile() . "\n";
    echo "❌ Line: " . $e->getLine() . "\n";
}

echo "\n=== TEST COMPLETE ===\n";