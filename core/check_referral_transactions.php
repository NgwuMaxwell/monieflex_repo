<?php

// Check for referral transactions with wrong wallet
require_once 'vendor/autoload.php';

// Set up Laravel environment
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== CHECKING REFERRAL TRANSACTIONS ===\n\n";

// Find transactions with referral details but wrong wallet
$wrongWalletTransactions = DB::select("
    SELECT id, user_id, wallet, amount, details 
    FROM transactions 
    WHERE details LIKE '%referral%' 
    AND wallet != 'referral_bonus'
");

if (empty($wrongWalletTransactions)) {
    echo "✅ No referral transactions found with wrong wallet!\n";
} else {
    echo "❌ Found " . count($wrongWalletTransactions) . " referral transactions with wrong wallet:\n\n";
    foreach ($wrongWalletTransactions as $transaction) {
        echo "ID: {$transaction->id}, User: {$transaction->user_id}, Wallet: {$transaction->wallet}, Amount: {$transaction->amount}\n";
        echo "Details: {$transaction->details}\n\n";
    }
}

// Also check for transactions with referral details but no wallet set
$nullWalletTransactions = DB::select("
    SELECT id, user_id, wallet, amount, details 
    FROM transactions 
    WHERE details LIKE '%referral%' 
    AND (wallet IS NULL OR wallet = '')
");

if (!empty($nullWalletTransactions)) {
    echo "❌ Found " . count($nullWalletTransactions) . " referral transactions with NULL/empty wallet:\n\n";
    foreach ($nullWalletTransactions as $transaction) {
        echo "ID: {$transaction->id}, User: {$transaction->user_id}, Wallet: '{$transaction->wallet}', Amount: {$transaction->amount}\n";
        echo "Details: {$transaction->details}\n\n";
    }
} else {
    echo "✅ No referral transactions found with NULL/empty wallet!\n";
}

echo "\n=== CHECK COMPLETE ===\n";