<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['name' => 'Piece', 'abbreviation' => 'pc', 'status' => 'active'],
            ['name' => 'Box', 'abbreviation' => 'box', 'status' => 'active'],
            ['name' => 'Pack', 'abbreviation' => 'pack', 'status' => 'active'],
            ['name' => 'Kilogram', 'abbreviation' => 'kg', 'status' => 'active'],
            ['name' => 'Gram', 'abbreviation' => 'g', 'status' => 'active'],
            ['name' => 'Liter', 'abbreviation' => 'l', 'status' => 'active'],
            ['name' => 'Milliliter', 'abbreviation' => 'ml', 'status' => 'active'],
            ['name' => 'Dozen', 'abbreviation' => 'doz', 'status' => 'active'],
            ['name' => 'Meter', 'abbreviation' => 'm', 'status' => 'active'],
            ['name' => 'Roll', 'abbreviation' => 'roll', 'status' => 'active'],
            ['name' => 'Bottle', 'abbreviation' => 'btl', 'status' => 'active'],
            ['name' => 'Can', 'abbreviation' => 'can', 'status' => 'active'],
            ['name' => 'Sachet', 'abbreviation' => 'sachet', 'status' => 'active'],
            ['name' => 'Sack', 'abbreviation' => 'sack', 'status' => 'active'],
            ['name' => 'Bar', 'abbreviation' => 'bar', 'status' => 'active'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
