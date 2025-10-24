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
                'name' => 'Juan Palamig Guyabano',
                'product_category_id' => 1, // Juice
                'product_unit_id' => 1, // Sachet
                'product_packaging_id' => 1, // 10 sachets per pack
                'price' => 25.00,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Juan Coffee Classic',
                'product_category_id' => 2, // Coffee
                'product_unit_id' => 1, // Sachet
                'product_packaging_id' => 2, // 24 sachets per box
                'price' => 55.00,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
