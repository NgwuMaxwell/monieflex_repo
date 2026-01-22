<?php

namespace App\Console\Commands;

use App\Models\PlanProfit;
use App\Models\User;
use Illuminate\Console\Command;

class AddDailyProfits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profits:add-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add daily profits to users\' profit wallets for active plans';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = now()->toDateString();

        // Get all users with active plans
        $activeUsers = User::whereNotNull('plan_id')
            ->where('expire_date', '>', now())
            ->with('plan')
            ->get();

        $this->info('Processing ' . $activeUsers->count() . ' active plan users');

        foreach ($activeUsers as $user) {
            // Check if profit already added today for this user and plan
            $existingProfit = PlanProfit::where('user_id', $user->id)
                ->where('plan_id', $user->plan_id)
                ->where('profit_date', $today)
                ->first();

            if ($existingProfit) {
                $this->info("Profit already added for user {$user->id} today");
                continue;
            }

            // Calculate daily profit
            $totalRoi = ($user->plan->price * $user->plan->roi_percentage) / 100;
            $dailyProfit = $totalRoi / $user->plan->validity;

            // Create profit record
            PlanProfit::create([
                'user_id' => $user->id,
                'plan_id' => $user->plan_id,
                'daily_profit' => $dailyProfit,
                'profit_date' => $today,
            ]);

            // Add to profit wallet
            $user->profit_wallet += $dailyProfit;
            $user->save();

            $this->info("Added profit of {$dailyProfit} to user {$user->id}");
        }

        $this->info('Daily profit distribution completed');
        return 0;
    }
}
