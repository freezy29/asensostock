<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VariantTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('variant_types')->insert([
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
            [
                'name' => 'Pack',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Innerbox',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mastebox',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
