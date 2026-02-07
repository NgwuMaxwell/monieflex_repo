<?php

// Debug script to check withdrawal and transaction state
require_once 'vendor/autoload.php';

// Set up Laravel environment
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\User;

// Get the current user ID (you'll need to replace this with the actual user ID)
$userId = 1; // Replace with actual user ID

// Try to find any user with transactions or withdrawals
$anyUser = \App\Models\User::whereHas('transactions')->orWhereHas('withdrawals')->first();
if (!$anyUser) {
    $anyUser = \App\Models\User::first();
}

if ($anyUser) {
    $userId = $anyUser->id;
    echo "Using user ID: {$userId} ({$anyUser->username})\n\n";
    
    // Check if this user has any transactions
    $transactionCount = \App\Models\Transaction::where('user_id', $userId)->count();
    $withdrawalCount = \App\Models\Withdrawal::where('user_id', $userId)->count();
    echo "User has {$transactionCount} transactions and {$withdrawalCount} withdrawals\n\n";
} else {
    echo "No users found in database\n";
    exit;
}

echo "=== WITHDRAWAL AND TRANSACTION DEBUG ===\n\n";

// Check recent withdrawals for this user
echo "Recent Withdrawals for User {$userId}:\n";
$withdrawals = Withdrawal::where('user_id', $userId)
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get();

if ($withdrawals->isEmpty()) {
    echo "No withdrawals found for this user\n";
} else {
    foreach ($withdrawals as $withdrawal) {
        $statusText = match($withdrawal->status) {
            1 => 'Approved',
            2 => 'Pending',
            3 => 'Rejected',
            default => 'Unknown'
        };
        echo "ID: {$withdrawal->id}, Amount: {$withdrawal->amount}, Status: {$statusText}, Wallet: {$withdrawal->wallet_type}, Created: {$withdrawal->created_at}\n";
    }
}

// Check all pending withdrawals in the system
echo "\nAll Pending Withdrawals in System:\n";
$pendingWithdrawals = Withdrawal::where('status', 2)
    ->orderBy('created_at', 'desc')
    ->limit(10)
    ->get();

if ($pendingWithdrawals->isEmpty()) {
    echo "No pending withdrawals found\n";
} else {
    foreach ($pendingWithdrawals as $withdrawal) {
        $user = User::find($withdrawal->user_id);
        echo "ID: {$withdrawal->id}, User: {$user->username}, Amount: {$withdrawal->amount}, Wallet: {$withdrawal->wallet_type}, Created: {$withdrawal->created_at}\n";
    }
}

echo "\nRecent Transactions:\n";
$transactions = Transaction::where('user_id', $userId)
    ->orderBy('created_at', 'desc')
    ->limit(10)
    ->get();

foreach ($transactions as $transaction) {
    echo "ID: {$transaction->id}, Type: {$transaction->trx_type}, Amount: {$transaction->amount}, Wallet: {$transaction->wallet}, Post Balance: {$transaction->post_balance}, Details: {$transaction->details}, Created: {$transaction->created_at}\n";
}

echo "\nWallet Balances (from transactions):\n";

// Calculate Profit Wallet balance
$profitWallet = Transaction::where('user_id', $userId)
    ->where('wallet', 'main_balance')
    ->sum(DB::raw("
        CASE 
            WHEN trx_type = '+' THEN amount
            WHEN trx_type = '-' THEN -amount
        END
    "));

// Calculate Referral Bonus balance
$referralWallet = Transaction::where('user_id', $userId)
    ->where('wallet', 'referral_bonus')
    ->sum(DB::raw("
        CASE 
            WHEN trx_type = '+' THEN amount
            WHEN trx_type = '-' THEN -amount
        END
    "));

echo "Profit Wallet: {$profitWallet}\n";
echo "Referral Bonus: {$referralWallet}\n";

echo "\nUser Table Balances:\n";
$user = User::find($userId);
echo "User Balance: {$user->balance}\n";
echo "User Profit Wallet: {$user->profit_wallet}\n";
echo "User Referral Bonus: {$user->referral_bonus}\n";

echo "\n=== END DEBUG ===\n";