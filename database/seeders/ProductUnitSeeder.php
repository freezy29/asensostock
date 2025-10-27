<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_units')->insert([
            [
                'product_id' => 1,
                'name' => 'Sachet',
                'quantity' => 1,
                'price' => 15.00,
                'stock_quantity' => 320,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'name' => 'Inner Box',
                'quantity' => 10,
                'price' => 140.00,
                'stock_quantity' => 45,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'name' => 'Master Box',
                'quantity' => 120,
                'price' => 1600.00,
                'stock_quantity' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'name' => 'Sachet',
                'quantity' => 1,
                'price' => 14.00,
                'stock_quantity' => 280,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'name' => 'Inner Box',
                'quantity' => 10,
                'price' => 135.00,
                'stock_quantity' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'name' => '50g pack',
                'quantity' => 1,
                'price' => 10.00,
                'stock_quantity' => 400,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'name' => 'Box',
                'quantity' => 12,
                'price' => 110.00,
                'stock_quantity' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
