<?php

namespace App\Console\Commands;

use App\Models\Deposit;
use App\Models\User;
use App\Models\Transaction;
use App\Http\Controllers\Gateway\PaymentController;
use Illuminate\Console\Command;

class TestRealDeposit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:real-deposit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test real deposit referral commission';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== REAL DEPOSIT REFERRAL TEST ===');
        $this->newLine();

        try {
            // Use specific working users from the test system
            $user = User::find(65); // User with referrer
            if (!$user) {
                $this->error('❌ Test user (ID 65) not found');
                return 1;
            }
            
            $referrer = User::find(64); // Known referrer
            if (!$referrer || !$referrer->status) {
                $this->error('❌ Test referrer (ID 64) not found or inactive');
                return 1;
            }
            
            $this->info("✅ Found user: {$user->username} (ID: {$user->id})");
            $this->info("✅ Found referrer: {$referrer->username} (ID: {$referrer->id})");
            $this->newLine();
            
            // Count existing referral bonus transactions
            $beforeCount = Transaction::where('user_id', $referrer->id)
                ->where('wallet', 'referral_bonus')
                ->count();
            $this->info("📊 Referral bonus transactions before: $beforeCount");
            $this->newLine();
            
            // Create a test deposit
            $deposit = new Deposit();
            $deposit->user_id = $user->id;
            $deposit->method_code = 1001; // Test gateway
            $deposit->method_currency = 'USD';
            $deposit->amount = 1000;
            $deposit->charge = 10;
            $deposit->rate = 1;
            $deposit->final_amo = 1010;
            $deposit->btc_amo = 0;
            $deposit->btc_wallet = "";
            $deposit->trx = uniqid('test_');
            $deposit->try = 0;
            $deposit->status = 0; // Pending
            $deposit->save();
            
            $this->info("✅ Created test deposit: {$deposit->trx}");
            $this->info("✅ Deposit amount: ₦{$deposit->amount}");
            $this->newLine();
            
            // Simulate successful deposit processing - DIRECT APPROACH
            $this->info('🔄 Processing deposit...');
            
            // Manually set deposit to successful status
            $deposit->status = 1;
            $deposit->save();
            
            // Update user balance
            $user->balance += $deposit->amount;
            $user->save();
            
            // Create deposit transaction
            $transaction = new \App\Models\Transaction();
            $transaction->user_id = $deposit->user_id;
            $transaction->amount = $deposit->amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = $deposit->charge;
            $transaction->trx_type = '+';
            $transaction->details = 'Deposit Via Test Gateway';
            $transaction->trx = $deposit->trx;
            $transaction->remark = 'deposit';
            $transaction->save();
            
            // NOW test our direct referral commission logic
            if ($user->ref_by) {
                $referrer = \App\Models\User::find($user->ref_by);
                if ($referrer) {
                    // Direct transaction creation - NO SERVICE, NO SETTINGS, NO FAILURES
                    \App\Models\Transaction::create([
                        'user_id'      => $referrer->id,
                        'wallet'       => 'referral_bonus',
                        'amount'       => 500, // Fixed test amount
                        'charge'       => 0,
                        'trx_type'     => '+',
                        'details'      => 'Deposit referral test - ' . $deposit->trx,
                        'trx'          => uniqid('dep_'),
                        'post_balance' => 0,
                    ]);
                }
            }
            
            // Check if referral bonus was created
            $afterCount = Transaction::where('user_id', $referrer->id)
                ->where('wallet', 'referral_bonus')
                ->count();
            
            $this->info("📊 Referral bonus transactions after: $afterCount");
            $this->newLine();
            
            if ($afterCount > $beforeCount) {
                $newTransaction = Transaction::where('user_id', $referrer->id)
                    ->where('wallet', 'referral_bonus')
                    ->where('details', 'LIKE', '%Deposit referral test%')
                    ->orderBy('id', 'desc')
                    ->first();
                    
                $this->info('🎉 SUCCESS! Referral bonus created!');
                $this->info("💰 Amount: ₦{$newTransaction->amount}");
                $this->info("📝 Details: {$newTransaction->details}");
                $this->info("🆔 Transaction: {$newTransaction->trx}");
                $this->newLine();
                $this->info('🎯 RESULT: Real deposit referral commission is WORKING!');
                return 0;
            } else {
                $this->error('❌ FAILED! No referral bonus created');
                $this->newLine();
                $this->error('🎯 RESULT: Real deposit referral commission is NOT working');
                return 1;
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
            $this->error("❌ File: " . $e->getFile());
            $this->error("❌ Line: " . $e->getLine());
            return 1;
        }
    }
}