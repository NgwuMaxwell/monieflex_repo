<?php
// Simple test to check if the referral system works
echo "Testing referral commission system...\n";

// Check if the service file exists
if (file_exists('app/Services/ReferralCommissionService.php')) {
    echo "✓ ReferralCommissionService exists\n";
} else {
    echo "✗ ReferralCommissionService not found\n";
    exit;
}

// Check if the helper function exists
if (function_exists('levelCommission')) {
    echo "✓ levelCommission function exists\n";
} else {
    echo "✗ levelCommission function not found\n";
    exit;
}

echo "Basic file checks passed\n";