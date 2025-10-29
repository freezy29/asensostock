<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('units')->insert([
            ['name' => 'Piece', 'abbreviation' => 'pc', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Box', 'abbreviation' => 'box', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pack', 'abbreviation' => 'pack', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kilogram', 'abbreviation' => 'kg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gram', 'abbreviation' => 'g', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Liter', 'abbreviation' => 'L', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Milliliter', 'abbreviation' => 'mL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dozen', 'abbreviation' => 'doz', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Meter', 'abbreviation' => 'm', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Roll', 'abbreviation' => 'roll', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
