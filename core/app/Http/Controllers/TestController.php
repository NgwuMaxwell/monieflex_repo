<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GeneralSetting;
use App\Models\Referral;
use Illuminate\Support\Facades\Cache;

class TestController extends Controller
{
    public function testReferralCommission()
    {
        echo "=== MANUAL REFERRAL COMMISSION DEBUG TEST ===<br><br>";

        // Test 1: Check if we can access the database
        echo "1. Testing database connection:<br>";
        try {
            $users = User::limit(5)->get();
            echo "   ✓ Found " . count($users) . " users in database<br>";
            if (count($users) > 0) {
                $testUser = $users->first();
                echo "   ✓ Test user: " . $testUser->username . " (ID: " . $testUser->id . ")<br>";
                echo "   ✓ Referrer ID: " . ($testUser->ref_by ? $testUser->ref_by : 'None') . "<br>";
            }
        } catch (\Exception $e) {
            echo "   ✗ Database connection failed: " . $e->getMessage() . "<br>";
        }

        // Test 2: Check general settings
        echo "<br>2. Testing general settings:<br>";
        try {
            $general = GeneralSetting::first();
            if ($general) {
                echo "   ✓ General settings found<br>";
                echo "   ✓ Deposit commission enabled: " . ($general->deposit_commission ? 'Yes' : 'No') . "<br>";
                echo "   ✓ PTC view commission enabled: " . ($general->ptc_view_commission ? 'Yes' : 'No') . "<br>";
                echo "   ✓ Plan subscribe commission enabled: " . ($general->plan_subscribe_commission ? 'Yes' : 'No') . "<br>";
            } else {
                echo "   ✗ No general settings found<br>";
            }
        } catch (\Exception $e) {
            echo "   ✗ General settings failed: " . $e->getMessage() . "<br>";
        }

        // Test 3: Check referral settings
        echo "<br>3. Testing referral settings:<br>";
        try {
            $referrals = Referral::where('commission_type', 'deposit_commission')->get();
            echo "   ✓ Found " . count($referrals) . " deposit commission levels<br>";
            foreach ($referrals as $referral) {
                echo "   ✓ Level " . $referral->level . ": " . $referral->percent . "%<br>";
            }
        } catch (\Exception $e) {
            echo "   ✗ Referral settings failed: " . $e->getMessage() . "<br>";
        }

        // Test 4: Manual commission test
        echo "<br>4. Testing manual commission calculation:<br>";
        try {
            $testUser = User::where('ref_by', '!=', null)->first();
            if ($testUser) {
                $referrer = User::find($testUser->ref_by);
                if ($referrer) {
                    echo "   ✓ Test scenario: " . $testUser->username . " referred by " . $referrer->username . "<br>";
                    
                    // Manual calculation
                    $amount = 1000;
                    $commissionPercent = 20; // Test with 20%
                    $commissionAmount = ($amount * $commissionPercent) / 100;
                    
                    echo "   ✓ Test amount: " . $amount . "<br>";
                    echo "   ✓ Commission percent: " . $commissionPercent . "%<br>";
                    echo "   ✓ Commission amount: " . $commissionAmount . "<br>";
                    echo "   ✓ Referrer current referral bonus: " . $referrer->referral_bonus . "<br>";
                    
                    // Try to manually credit
                    echo "<br>5. Attempting manual credit:<br>";
                    $oldBonus = $referrer->referral_bonus;
                    $referrer->referral_bonus += $commissionAmount;
                    $referrer->save();
                    
                    // Check if it worked
                    $referrer->refresh();
                    $newBonus = $referrer->referral_bonus;
                    
                    echo "   ✓ Old bonus: " . $oldBonus . "<br>";
                    echo "   ✓ New bonus: " . $newBonus . "<br>";
                    echo "   ✓ Difference: " . ($newBonus - $oldBonus) . "<br>";
                    
                    if ($newBonus - $oldBonus == $commissionAmount) {
                        echo "   ✓ MANUAL CREDIT SUCCESSFUL!<br>";
                    } else {
                        echo "   ✗ MANUAL CREDIT FAILED!<br>";
                    }
                } else {
                    echo "   ✗ No referrer found for test user<br>";
                }
            } else {
                echo "   ✗ No users with referrers found<br>";
            }
        } catch (\Exception $e) {
            echo "   ✗ Manual test failed: " . $e->getMessage() . "<br>";
            echo "   ✗ Error details: " . $e->getTraceAsString() . "<br>";
        }

        echo "<br>=== DEBUG TEST COMPLETE ===<br>";
    }
}