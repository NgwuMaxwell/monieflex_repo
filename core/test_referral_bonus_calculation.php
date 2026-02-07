<?php

// Test script to verify referral bonus calculation
require_once 'core/bootstrap/app.php';

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

echo "Testing Referral Bonus Calculation\n";
echo "==================================\n\n";

try {
    $user = User::first();
    if (!$user) {
        echo "✗ No users found in database\n";
        exit;
    }
    
    echo "Testing user: " . $user->username . "\n";
    echo "User ID: " . $user->id . "\n\n";
    
    // Test 1: Check if referral_bonus field exists in users table
    echo "Test 1: Checking if referral_bonus field exists in users table...\n";
    try {
        $columns = DB::getSchemaBuilder()->getColumnListing('users');
        if (in_array('referral_bonus', $columns)) {
            echo "✓ referral_bonus field exists in users table\n";
            echo "  Current value: " . $user->referral_bonus . "\n";
        } else {
            echo "✗ referral_bonus field NOT found in users table\n";
        }
    } catch (Exception $e) {
        echo "✗ Error checking database: " . $e->getMessage() . "\n";
    }
    
    // Test 2: Check transactions for referral_bonus
    echo "\nTest 2: Checking referral_bonus transactions...\n";
    try {
        $positiveTransactions = Transaction::where('user_id', $user->id)
            ->where('wallet', 'referral_bonus')
            ->where('trx_type', '+')
            ->sum('amount');
        
        $negativeTransactions = Transaction::where('user_id', $user->id)
            ->where('wallet', 'referral_bonus')
            ->where('trx_type', '-')
            ->sum('amount');
        
        $calculatedBonus = $positiveTransactions - $negativeTransactions;
        
        echo "✓ Positive transactions: " . $positiveTransactions . "\n";
        echo "✓ Negative transactions: " . $negativeTransactions . "\n";
        echo "✓ Calculated referral bonus: " . $calculatedBonus . "\n";
    } catch (Exception $e) {
        echo "✗ Error checking transactions: " . $e->getMessage() . "\n";
    }
    
    // Test 3: Test the referralBonus attribute
    echo "\nTest 3: Testing referralBonus attribute...\n";
    try {
        $attributeBonus = $user->referralBonus;
        echo "✓ referralBonus attribute: " . $attributeBonus . "\n";
    } catch (Exception $e) {
        echo "✗ Error with referralBonus attribute: " . $e->getMessage() . "\n";
    }
    
    // Test 4: Test the getReferralBonusAttribute method
    echo "\nTest 4: Testing getReferralBonusAttribute method...\n";
    try {
        $methodBonus = $user->getReferralBonusAttribute();
        echo "✓ getReferralBonusAttribute method: " . $methodBonus . "\n";
    } catch (Exception $e) {
        echo "✗ Error with getReferralBonusAttribute method: " . $e->getMessage() . "\n";
    }
    
    // Test 5: Test direct access to $user->referral_bonus
    echo "\nTest 5: Testing direct access to \$user->referral_bonus...\n";
    try {
        $directBonus = $user->referral_bonus;
        echo "✓ Direct access: " . $directBonus . "\n";
    } catch (Exception $e) {
        echo "✗ Error with direct access: " . $e->getMessage() . "\n";
    }
    
    echo "\nTest Summary:\n";
    echo "- The referral bonus calculation should use the calculated attribute\n";
    echo "- Not the direct database field (if it exists)\n";
    echo "- Make sure transactions exist with wallet='referral_bonus'\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}