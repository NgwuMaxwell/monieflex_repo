<?php
// Final test script for referral commission system
echo "=== Testing Referral Commission System ===\n\n";

// Test 1: Check if files exist
echo "1. Checking file existence:\n";
$files = [
    'app/Services/SimpleReferralService.php',
    'app/Http/Helpers/helpers.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "   ✓ $file exists\n";
    } else {
        echo "   ✗ $file missing\n";
    }
}

// Test 2: Check if function exists
echo "\n2. Checking function existence:\n";
if (function_exists('levelCommission')) {
    echo "   ✓ levelCommission function exists\n";
} else {
    echo "   ✗ levelCommission function missing\n";
}

// Test 3: Check if service class exists
echo "\n3. Checking service class:\n";
if (class_exists('App\Services\SimpleReferralService')) {
    echo "   ✓ SimpleReferralService class exists\n";
} else {
    echo "   ✗ SimpleReferralService class missing\n";
}

echo "\n=== Test Complete ===\n";
echo "If all checks passed, the referral system should work.\n";