<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_categories')->insert([
            [
                'name' => 'Coffee',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Juice',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
