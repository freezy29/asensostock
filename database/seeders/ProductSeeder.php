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
                'name' => 'Nescafe 3-in-1 Sachet',
                'product_category_id' => 1,
                'critical_level' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Great Taste White',
                'product_category_id' => 1,
                'critical_level' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tang Mango Powder',
                'product_category_id' => 2,
                'critical_level' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Minute Maid Orange Bottle',
                'product_category_id' => 2,
                'critical_level' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
