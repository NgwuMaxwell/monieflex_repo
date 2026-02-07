<?php
// Simple direct referral credit function
function simpleReferralCredit($userId, $amount, $description = 'Referral Commission')
{
    try {
        // Get the user
        $user = \App\Models\User::find($userId);
        if (!$user) {
            return false;
        }
        
        // Get the referrer
        $referrerId = $user->ref_by;
        if (!$referrerId) {
            return false;
        }
        
        // Get the referrer
        $referrer = \App\Models\User::find($referrerId);
        if (!$referrer) {
            return false;
        }
        
        // Skip inactive referrers
        if (!$referrer->status || $referrer->ts == 0) {
            return false;
        }
        
        // Directly credit the referral bonus
        $oldBonus = $referrer->referral_bonus;
        $newBonus = $oldBonus + $amount;
        
        // Update the referrer's referral bonus
        $referrer->referral_bonus = $newBonus;
        $referrer->save();
        
        // Create a transaction record
        $transaction = new \App\Models\Transaction();
        $transaction->user_id = $referrer->id;
        $transaction->amount = $amount;
        $transaction->post_balance = $newBonus;
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = $description . ' from ' . $user->username;
        $transaction->remark = 'referral_commission';
        $transaction->trx = strtoupper(uniqid('RC'));
        $transaction->save();
        
        return true;
        
    } catch (\Exception $e) {
        error_log('SimpleReferralCredit failed: ' . $e->getMessage());
        return false;
    }
}

// Test the function
echo "Testing simple referral credit function:\n";

// Find a user with a referrer
$user = \App\Models\User::where('ref_by', '!=', null)->first();
if ($user) {
    $referrer = \App\Models\User::find($user->ref_by);
    echo "User: " . $user->username . " (ID: " . $user->id . ")\n";
    echo "Referrer: " . $referrer->username . " (ID: " . $referrer->id . ")\n";
    echo "Referrer current bonus: " . $referrer->referral_bonus . "\n";
    
    // Test the function
    $result = simpleReferralCredit($user->id, 1000, 'Test Commission');
    echo "Result: " . ($result ? 'SUCCESS' : 'FAILED') . "\n";
    
    // Check if bonus was updated
    $referrer->refresh();
    echo "New referrer bonus: " . $referrer->referral_bonus . "\n";
    
} else {
    echo "No users with referrers found\n";
}