<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DepositAmount;

class DepositAmountSeeder extends Seeder
{
    public function run()
    {
        $amounts = [6000, 10000, 15000, 20000, 25000, 50000];
        
        foreach ($amounts as $amount) {
            DepositAmount::create([
                'amount' => $amount,
                'status' => true,
            ]);
        }
    }
}