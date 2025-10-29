<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Workers Blend Coffee 3-in-1 16g',
                'category_id' => 1, // Example: Beverages
                'unit_id' => 1,     // Piece
                'stock_quantity' => 120,
                'unit_price' => 6.50,
                'cost_price' => 4.00,
                'reorder_level' => 50,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Surf Powder Detergent 45g',
                'category_id' => 2, // Example: Household
                'unit_id' => 1,     // Piece
                'stock_quantity' => 80,
                'unit_price' => 8.00,
                'cost_price' => 5.25,
                'reorder_level' => 30,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SkyFlakes Crackers 10s Pack',
                'category_id' => 3, // Example: Snacks
                'unit_id' => 3,     // Pack
                'stock_quantity' => 40,
                'unit_price' => 42.00,
                'cost_price' => 32.00,
                'reorder_level' => 20,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Coca-Cola 1.5L',
                'category_id' => 1, // Beverages
                'unit_id' => 6,     // Liter
                'stock_quantity' => 60,
                'unit_price' => 65.00,
                'cost_price' => 55.00,
                'reorder_level' => 15,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lucky Me Pancit Canton 60g',
                'category_id' => 3, // Snacks
                'unit_id' => 1,     // Piece
                'stock_quantity' => 100,
                'unit_price' => 14.00,
                'cost_price' => 10.00,
                'reorder_level' => 40,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
