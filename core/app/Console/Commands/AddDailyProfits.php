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
        $now = now();

        // Get all users with active plans
        $activeUsers = User::whereNotNull('plan_id')
            ->where('expire_date', '>', $now)
            ->with('plan')
            ->get();

        $this->info('Processing ' . $activeUsers->count() . ' active plan users');

        foreach ($activeUsers as $user) {
            // Find the plan subscription transaction to get purchase date
            $planTransaction = \App\Models\Transaction::where('user_id', $user->id)
                ->where('remark', 'subscribe_plan')
                ->where('details', 'like', '%'.$user->plan->name.'%')
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$planTransaction) {
                $this->info("No subscription transaction found for user {$user->id}");
                continue;
            }

            $purchaseDate = $planTransaction->created_at;
            $hoursSincePurchase = $purchaseDate->diffInHours($now);

            // Only start adding profits after 24 hours
            if ($hoursSincePurchase < 24) {
                $this->info("User {$user->id} plan purchased {$hoursSincePurchase} hours ago - waiting 24 hours");
                continue;
            }

            // Calculate which day this profit represents (1-based)
            $daysSincePurchase = $purchaseDate->diffInDays($now);
            $profitDay = $daysSincePurchase; // Day 1 is 24 hours after purchase

            // Don't add profits beyond plan validity
            if ($profitDay > $user->plan->validity) {
                $this->info("User {$user->id} has reached maximum profit days");
                continue;
            }

            // Check if profit already added for this day
            $existingProfit = PlanProfit::where('user_id', $user->id)
                ->where('plan_subscription_id', $user->plan_id)
                ->where('day', $profitDay)
                ->first();

            if ($existingProfit) {
                $this->info("Profit already added for user {$user->id} day {$profitDay}");
                continue;
            }

            // Calculate daily profit
            $totalRoi = ($user->plan->price * $user->plan->roi_percentage) / 100;
            $dailyProfit = $totalRoi / $user->plan->validity;

            // Create profit record
            PlanProfit::create([
                'user_id' => $user->id,
                'plan_subscription_id' => $user->plan_id,
                'amount' => $dailyProfit,
                'day' => $profitDay,
                'total_days' => $user->plan->validity,
            ]);

            // Add to profit wallet
            $user->profit_wallet += $dailyProfit;
            $user->save();

            $this->info("Added profit of {$dailyProfit} to user {$user->id} for day {$profitDay}");
        }

        $this->info('Daily profit distribution completed');
        return 0;
    }
}
