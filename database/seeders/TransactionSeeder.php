<?php

namespace Database\Seeders;

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
        DB::table('transactions')->insert([
            [
                'product_id' => '1',
                'type' => 'in',
                'quantity' => 50,
                'previous_stock' => 100, // 10 sachets per pack
                'new_stock' => 150,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => '2',
                'type' => 'out',
                'quantity' => 10,
                'previous_stock' => 80,
                'new_stock' => 70,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
