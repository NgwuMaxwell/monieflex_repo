<?php
// Test new commission functionality
echo "=== Testing New Commission System ===\n\n";

// Create a test deposit to trigger commission
$user = \App\Models\User::where('ref_by', '!=', null)->first();

if ($user) {
    $referrer = \App\Models\User::find($user->ref_by);
    
    echo "Test scenario:\n";
    echo "- User: " . $user->username . " (ID: " . $user->id . ")\n";
    echo "- Referrer: " . $referrer->username . " (ID: " . $referrer->id . ")\n";
    
    // Get current referral bonus balance
    $currentBalance = \App\Models\Transaction::where('user_id', $referrer->id)
        ->where('wallet', 'referral_bonus')
        ->selectRaw("SUM(CASE WHEN trx_type='+' THEN amount ELSE -amount END) as total")
        ->value('total') ?? 0;
    
    echo "- Current referral bonus balance: " . $currentBalance . "\n";
    
    // Test the ReferralCommissionService directly
    echo "\nTesting ReferralCommissionService:\n";
    $commissionService = new \App\Services\ReferralCommissionService();
    $result = $commissionService->awardCommission($user, 'deposit', 1000, null, 'TEST123');
    
    echo "Result: " . ($result ? 'SUCCESS' : 'FAILED') . "\n";
    
    // Check new balance
    $newBalance = \App\Models\Transaction::where('user_id', $referrer->id)
        ->where('wallet', 'referral_bonus')
        ->selectRaw("SUM(CASE WHEN trx_type='+' THEN amount ELSE -amount END) as total")
        ->value('total') ?? 0;
    
    echo "- New referral bonus balance: " . $newBalance . "\n";
    echo "- Balance change: " . ($newBalance - $currentBalance) . "\n";
    
    // Check for new transactions
    $newTransactions = \App\Models\Transaction::where('user_id', $referrer->id)
        ->where('wallet', 'referral_bonus')
        ->where('trx', 'TEST123')
        ->get();
    
    echo "- New transactions found: " . count($newTransactions) . "\n";
    foreach ($newTransactions as $transaction) {
        echo "  - " . $transaction->amount . " NGN (" . $transaction->details . ")\n";
    }
    
} else {
    echo "No users with referrers found in database\n";
}

echo "\n=== Test Complete ===\n";