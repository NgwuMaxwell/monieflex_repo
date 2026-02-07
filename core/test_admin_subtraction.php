<?php

// Simple test to verify admin subtraction works
require_once 'core/bootstrap/app.php';

use App\Models\User;
use App\Models\Transaction;

echo "=== TESTING ADMIN SUBTRACTION ===\n\n";

try {
    // Use specific working user
    $user = User::find(65);
    
    if (!$user) {
        echo "❌ Test user not found\n";
        exit;
    }
    
    echo "✅ Found user: {$user->username} (ID: {$user->id})\n\n";
    
    // Get current referral bonus
    $currentBalance = $user->referral_bonus;
    echo "📊 Current referral bonus: ₦{$currentBalance}\n\n";
    
    // Simulate admin subtraction of 1000
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
    
    // Get updated balance
    $updatedUser = User::find($user->id);
    $newBalance = $updatedUser->referral_bonus;
    
    echo "📊 New referral bonus: ₦{$newBalance}\n";
    echo "📊 Expected decrease: ₦1000\n";
    echo "📊 Actual decrease: ₦" . ($currentBalance - $newBalance) . "\n\n";
    
    if ($currentBalance - $newBalance == 1000) {
        echo "🎉 SUCCESS! Admin subtraction is working correctly!\n";
        echo "   - Old balance: ₦{$currentBalance}\n";
        echo "   - New balance: ₦{$newBalance}\n";
        echo "   - Decrease: ₦" . ($currentBalance - $newBalance) . "\n";
        echo "   - Expected: ₦1000\n";
        echo "   - Match: ✅\n";
    } else {
        echo "❌ FAILED! Admin subtraction is not working correctly!\n";
        echo "   - Old balance: ₦{$currentBalance}\n";
        echo "   - New balance: ₦{$newBalance}\n";
        echo "   - Decrease: ₦" . ($currentBalance - $newBalance) . "\n";
        echo "   - Expected: ₦1000\n";
        echo "   - Match: ❌\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "❌ File: " . $e->getFile() . "\n";
    echo "❌ Line: " . $e->getLine() . "\n";
}

echo "\n=== TEST COMPLETE ===\n";