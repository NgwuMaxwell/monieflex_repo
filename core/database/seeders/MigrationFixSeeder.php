<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrationFixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert the core Laravel migrations that already exist
        $migrations = [
            ['migration' => '2014_10_12_000000_create_users_table', 'batch' => 1],
            ['migration' => '2014_10_12_100000_create_password_resets_table', 'batch' => 1],
            ['migration' => '2019_08_19_000000_create_failed_jobs_table', 'batch' => 1],
            ['migration' => '2019_12_14_000001_create_personal_access_tokens_table', 'batch' => 1],
            ['migration' => '2022_02_26_061836_create_forms_table', 'batch' => 1],
            ['migration' => '2026_01_18_000000_add_image_to_plans_table', 'batch' => 1],
            ['migration' => '2026_01_19_012440_add_profit_wallet_to_users_table', 'batch' => 1],
            ['migration' => '2026_01_19_012441_create_plan_profits_table', 'batch' => 1],
            ['migration' => '2026_01_19_012442_add_roi_to_plans_table', 'batch' => 1],
            ['migration' => '2026_01_23_005113_create_notices_table', 'batch' => 1],
            ['migration' => '2026_01_23_005114_add_return_capital_to_plans_table', 'batch' => 1],
            ['migration' => '2026_01_26_210801_add_referral_bonus_to_users_table', 'batch' => 1],
        ];

        foreach ($migrations as $migration) {
            DB::table('migrations')->insert($migration);
            echo "Inserted migration: " . $migration['migration'] . "\n";
        }
        
        echo "All core migrations marked as run successfully!\n";
    }
}