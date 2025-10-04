<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MeasureUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('measure_units')->insert([
            [
                'name' => 'Gram',
                'abbreviation' => 'g',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Milliliter',
                'abbreviation' => 'ml',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Liter',
                'abbreviation' => 'L',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Piece',
                'abbreviation' => 'pcs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
