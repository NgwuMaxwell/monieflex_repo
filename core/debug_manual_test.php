<?php
// Manual debug test to understand what's happening
echo "=== MANUAL REFERRAL COMMISSION DEBUG TEST ===\n\n";

// Test 1: Check if we can access the database
echo "1. Testing database connection:\n";
try {
    $users = \App\Models\User::limit(5)->get();
    echo "   ✓ Found " . count($users) . " users in database\n";
    if (count($users) > 0) {
        $testUser = $users->first();
        echo "   ✓ Test user: " . $testUser->username . " (ID: " . $testUser->id . ")\n";
        echo "   ✓ Referrer ID: " . ($testUser->ref_by ? $testUser->ref_by : 'None') . "\n";
    }
} catch (Exception $e) {
    echo "   ✗ Database connection failed: " . $e->getMessage() . "\n";
}

// Test 2: Check general settings
echo "\n2. Testing general settings:\n";
try {
    $general = \App\Models\GeneralSetting::first();
    if ($general) {
        echo "   ✓ General settings found\n";
        echo "   ✓ Deposit commission enabled: " . ($general->deposit_commission ? 'Yes' : 'No') . "\n";
        echo "   ✓ PTC view commission enabled: " . ($general->ptc_view_commission ? 'Yes' : 'No') . "\n";
        echo "   ✓ Plan subscribe commission enabled: " . ($general->plan_subscribe_commission ? 'Yes' : 'No') . "\n";
    } else {
        echo "   ✗ No general settings found\n";
    }
} catch (Exception $e) {
    echo "   ✗ General settings failed: " . $e->getMessage() . "\n";
}

// Test 3: Check referral settings
echo "\n3. Testing referral settings:\n";
try {
    $referrals = \App\Models\Referral::where('commission_type', 'deposit_commission')->get();
    echo "   ✓ Found " . count($referrals) . " deposit commission levels\n";
    foreach ($referrals as $referral) {
        echo "   ✓ Level " . $referral->level . ": " . $referral->percent . "%\n";
    }
} catch (Exception $e) {
    echo "   ✗ Referral settings failed: " . $e->getMessage() . "\n";
}

// Test 4: Manual commission test
echo "\n4. Testing manual commission calculation:\n";
try {
    $testUser = \App\Models\User::where('ref_by', '!=', null)->first();
    if ($testUser) {
        $referrer = \App\Models\User::find($testUser->ref_by);
        if ($referrer) {
            echo "   ✓ Test scenario: " . $testUser->username . " referred by " . $referrer->username . "\n";
            
            // Manual calculation
            $amount = 1000;
            $commissionPercent = 20; // Test with 20%
            $commissionAmount = ($amount * $commissionPercent) / 100;
            
            echo "   ✓ Test amount: " . $amount . "\n";
            echo "   ✓ Commission percent: " . $commissionPercent . "%\n";
            echo "   ✓ Commission amount: " . $commissionAmount . "\n";
            echo "   ✓ Referrer current referral bonus: " . $referrer->referral_bonus . "\n";
            
            // Try to manually credit
            echo "\n5. Attempting manual credit:\n";
            $oldBonus = $referrer->referral_bonus;
            $referrer->referral_bonus += $commissionAmount;
            $referrer->save();
            
            // Check if it worked
            $referrer->refresh();
            $newBonus = $referrer->referral_bonus;
            
            echo "   ✓ Old bonus: " . $oldBonus . "\n";
            echo "   ✓ New bonus: " . $newBonus . "\n";
            echo "   ✓ Difference: " . ($newBonus - $oldBonus) . "\n";
            
            if ($newBonus - $oldBonus == $commissionAmount) {
                echo "   ✓ MANUAL CREDIT SUCCESSFUL!\n";
            } else {
                echo "   ✗ MANUAL CREDIT FAILED!\n";
            }
        } else {
            echo "   ✗ No referrer found for test user\n";
        }
    } else {
        echo "   ✗ No users with referrers found\n";
    }
} catch (Exception $e) {
    echo "   ✗ Manual test failed: " . $e->getMessage() . "\n";
    echo "   ✗ Error details: " . $e->getTraceAsString() . "\n";
}

echo "\n=== DEBUG TEST COMPLETE ===\n";