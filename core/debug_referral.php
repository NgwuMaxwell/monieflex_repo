<?php
// Simple debug script to test referral commission system
require_once 'vendor/autoload.php';

// Set up Laravel environment
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Services\ReferralCommissionService;

try {
    // Get a test user
    $user = User::first();
    if (!$user) {
        echo "No users found in database\n";
        exit;
    }
    
    echo "Testing referral commission for user: " . $user->username . "\n";
    echo "User has ref_by: " . ($user->ref_by ? $user->ref_by : 'No') . "\n";
    
    // Test deposit commission
    $service = new ReferralCommissionService();
    $result = $service->awardCommission($user, 'deposit', 1000);
    
    echo "Deposit commission result: " . ($result ? 'SUCCESS' : 'FAILED') . "\n";
    
    // Check if referrer got credited
    if ($user->ref_by) {
        $referrer = User::find($user->ref_by);
        if ($referrer) {
            echo "Referrer referral_bonus: " . $referrer->referral_bonus . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}