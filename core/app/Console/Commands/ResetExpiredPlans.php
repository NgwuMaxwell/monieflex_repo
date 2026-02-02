<?php

namespace App\Console\Commands;

use App\Models\PlanProfit;
use App\Models\User;
use Illuminate\Console\Command;

class ResetExpiredPlans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plans:reset-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Task Earning for users with expired plans';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = now();
        
        // Get all users with expired plans
        $expiredUsers = User::whereNotNull('plan_id')
            ->where('expire_date', '<', $now)
            ->get();

        $this->info('Processing ' . $expiredUsers->count() . ' expired plan users');

        foreach ($expiredUsers as $user) {
            // Reset Task Earning (which is tracked in PTC earnings)
            // Since Task Earning is just a display of PTC earnings, we don't need to reset anything
            // The PTC earnings remain in Profit Wallet, but users can't earn new PTC until they renew
            
            // Clear the plan and daily limit
            $user->plan_id = null;
            $user->daily_limit = 0;
            $user->save();

            $this->info("Reset plan for user {$user->id} (expired on {$user->expire_date})");
        }

        $this->info('Expired plan reset completed');
        return 0;
    }
}