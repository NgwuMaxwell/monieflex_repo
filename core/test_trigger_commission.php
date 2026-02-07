<?php
// Simple test to manually trigger referral commission
echo "=== MANUAL COMMISSION TRIGGER TEST ===\n\n";

// Test the directReferralCommission function directly
echo "Testing directReferralCommission function:\n";

// Find a user with a referrer
$testUser = \App\Models\User::where('ref_by', '!=', null)->first();

if ($testUser) {
    $referrer = \App\Models\User::find($testUser->ref_by);
    
    echo "Test scenario:\n";
    echo "- User: " . $testUser->username . " (ID: " . $testUser->id . ")\n";
    echo "- Referrer: " . $referrer->username . " (ID: " . $referrer->id . ")\n";
    echo "- Referrer current bonus: " . $referrer->referral_bonus . "\n\n";
    
    // Test deposit commission
    echo "Testing deposit commission:\n";
    $result = directReferralCommission($testUser->id, 'deposit', 1000);
    echo "Result: " . ($result ? 'SUCCESS' : 'FAILED') . "\n";
    
    // Check if bonus was updated
    $referrer->refresh();
    echo "New referrer bonus: " . $referrer->referral_bonus . "\n";
    
    // Test PTC view commission
    echo "\nTesting PTC view commission:\n";
    $result2 = directReferralCommission($testUser->id, 'ptc_view', 100);
    echo "Result: " . ($result2 ? 'SUCCESS' : 'FAILED') . "\n";
    
    // Check if bonus was updated again
    $referrer->refresh();
    echo "New referrer bonus: " . $referrer->referral_bonus . "\n";
    
    // Test plan subscription commission
    echo "\nTesting plan subscription commission:\n";
    $result3 = directReferralCommission($testUser->id, 'plan_subscription', 5000);
    echo "Result: " . ($result3 ? 'SUCCESS' : 'FAILED') . "\n";
    
    // Check final bonus
    $referrer->refresh();
    echo "Final referrer bonus: " . $referrer->referral_bonus . "\n";
    
} else {
    echo "No users with referrers found in database\n";
}

echo "\n=== TEST COMPLETE ===\n";
echo "Check the error log for debug messages\n";