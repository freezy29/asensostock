<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductPackagingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_packaging')->insert([
            [
                'name' => '10 sachets per pack',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '24 sachets per box',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '1 liter bottle',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
