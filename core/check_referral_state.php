<?php
// Check current referral bonus state
echo "=== Checking Referral Bonus State ===\n\n";

// Check if any referral bonus transactions exist
$referralTransactions = \App\Models\Transaction::where('wallet', 'referral_bonus')->count();
echo "Referral bonus transactions in database: " . $referralTransactions . "\n";

if ($referralTransactions > 0) {
    echo "✅ Referral bonus transactions exist!\n";
    $transactions = \App\Models\Transaction::where('wallet', 'referral_bonus')->get();
    foreach ($transactions as $transaction) {
        echo "- User " . $transaction->user_id . ": " . $transaction->amount . " NGN (" . $transaction->details . ")\n";
    }
} else {
    echo "❌ NO referral bonus transactions found!\n";
    echo "This proves the system is NOT working.\n";
}

// Check if ReferralBonus model has any records
$referralBonusRecords = \App\Models\ReferralBonus::count();
echo "\nReferralBonus model records: " . $referralBonusRecords . "\n";

// Check admin settings
$general = \App\Models\GeneralSetting::first();
if ($general) {
    echo "\nAdmin settings:\n";
    echo "- Deposit commission enabled: " . ($general->deposit_commission ? 'YES' : 'NO') . "\n";
    echo "- Plan subscribe commission enabled: " . ($general->plan_subscribe_commission ? 'YES' : 'NO') . "\n";
    echo "- PTC view commission enabled: " . ($general->ptc_view_commission ? 'YES' : 'NO') . "\n";
    echo "- Signup commission enabled: " . ($general->signup_commission ? 'YES' : 'NO') . "\n";
} else {
    echo "\n❌ No GeneralSetting found!\n";
}

// Check referral settings
$referralSettings = \App\Models\Referral::all();
echo "\nReferral settings found: " . $referralSettings->count() . "\n";
foreach ($referralSettings as $setting) {
    echo "- Type: " . $setting->commission_type . ", Level: " . $setting->level . ", Percent: " . $setting->percent . "%\n";
}

echo "\n=== Test Complete ===\n";