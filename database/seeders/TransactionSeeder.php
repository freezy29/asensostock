<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('transactions')->insert([
            // Incoming (restock) transactions
            [
                'product_id' => 1,
                'type' => 'in',
                'quantity' => 100,
                'cost_price' => 4.00,
                'total_amount' => 400.00,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => 2,
                'type' => 'in',
                'quantity' => 50,
                'cost_price' => 25.00,
                'total_amount' => 1250.00,
                'user_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Outgoing (sales) transactions
            [
                'product_id' => 1,
                'type' => 'out',
                'quantity' => 20,
                'cost_price' => 4.00,
                'total_amount' => 130.00, // sold at ₱6.50 each approx
                'user_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => 2,
                'type' => 'out',
                'quantity' => 10,
                'cost_price' => 25.00,
                'total_amount' => 350.00, // sold at ₱35 each
                'user_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
