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
                'name' => 'Sachet',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Box',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bottle',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
