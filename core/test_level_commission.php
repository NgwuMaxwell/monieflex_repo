<?php
// Test the levelCommission function directly
echo "=== Testing levelCommission Function ===\n\n";

// Test with a real user
$user = \App\Models\User::where('ref_by', '!=', null)->first();

if ($user) {
    $referrer = \App\Models\User::find($user->ref_by);
    
    echo "Test scenario:\n";
    echo "- User: " . $user->username . " (ID: " . $user->id . ")\n";
    echo "- Referrer: " . $referrer->username . " (ID: " . $referrer->id . ")\n";
    
    // Test the levelCommission function with different sources
    echo "\n1. Testing deposit commission:\n";
    $result1 = levelCommission($user->id, 'deposit', 1000);
    echo "Result: " . ($result1 ? 'SUCCESS' : 'FAILED') . "\n";
    
    echo "\n2. Testing PTC view commission:\n";
    $result2 = levelCommission($user->id, 'ptc_view', 100);
    echo "Result: " . ($result2 ? 'SUCCESS' : 'FAILED') . "\n";
    
    echo "\n3. Testing plan subscription commission:\n";
    $result3 = levelCommission($user->id, 'plan_subscription', 5000);
    echo "Result: " . ($result3 ? 'SUCCESS' : 'FAILED') . "\n";
    
    echo "\n4. Testing signup commission:\n";
    $result4 = levelCommission($user->id, 'signup', 0);
    echo "Result: " . ($result4 ? 'SUCCESS' : 'FAILED') . "\n";
    
    // Check if any transactions were created
    echo "\n5. Checking for new transactions:\n";
    $transactions = \App\Models\Transaction::where('user_id', $referrer->id)
        ->where('wallet', 'referral_bonus')
        ->where('created_at', '>', now()->subMinutes(5))
        ->get();
    
    echo "New transactions found: " . count($transactions) . "\n";
    foreach ($transactions as $transaction) {
        echo "- " . $transaction->amount . " NGN (" . $transaction->details . ")\n";
    }
    
} else {
    echo "No users with referrers found in database\n";
}

echo "\n=== Test Complete ===\n";