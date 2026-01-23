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

            // Calculate which day of profits this should be (1-based, starting after 24 hours)
            $profitDay = floor($hoursSincePurchase / 24);

            // Skip if it's Day 0 (less than 24 hours since purchase)
            if ($profitDay < 1) {
                $this->info("User {$user->id} plan purchased {$hoursSincePurchase} hours ago - waiting for Day 1 profits (24+ hours)");
                continue;
            }

            // Don't add profits beyond plan validity
            if ($profitDay > $user->plan->validity) {
                $this->info("User {$user->id} has reached maximum profit days ({$user->plan->validity})");
                continue;
            }

            // Calculate the date when this profit should be earned (purchase date + profit day)
            $profitEarnedDate = $purchaseDate->copy()->addDays($profitDay)->toDateString();

            // Only add profit if we're on or past the date it should be earned
            if ($today < $profitEarnedDate) {
                $this->info("User {$user->id} profit for day {$profitDay} not yet due (earned on: {$profitEarnedDate})");
                continue;
            }

            // Check if profit already added for this specific profit day
            $existingProfit = PlanProfit::where('user_id', $user->id)
                ->where('plan_id', $user->plan_id)
                ->where('profit_date', $profitEarnedDate)
                ->first();

            if ($existingProfit) {
                $this->info("Profit already added for user {$user->id} for day {$profitDay} (date: {$profitEarnedDate})");
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
                'profit_date' => $profitEarnedDate,
            ]);

            // Add to profit wallet
            $user->profit_wallet += $dailyProfit;

            // If this is the last profit day and return_capital is enabled, add the capital back
            if ($profitDay == $user->plan->validity && $user->plan->return_capital) {
                $user->profit_wallet += $user->plan->price;
                $this->info("Returned capital of {$user->plan->price} to user {$user->id} for completing plan");
            }

            $user->save();

            $this->info("Added profit of {$dailyProfit} to user {$user->id} for day {$profitDay}");
        }

        $this->info('Daily profit distribution completed');
        return 0;
    }
}
