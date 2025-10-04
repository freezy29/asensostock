<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_variants')->insert([
            // Nescafe 3-in-1
            [
                'product_id' => 1,
                'variant_type_id' => 1, // Sachet
                'measure_value' => 20,
                'measure_unit_id' => 1, // g
                'conversion_rate' => 1,
                'price' => 5.00,
                'current_qty' => 200,
                'critical_level' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'variant_type_id' => 2, // Box
                'measure_value' => 10,
                'measure_unit_id' => 4, // pcs
                'conversion_rate' => 10,
                'price' => 50.00,
                'current_qty' => 50,
                'critical_level' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Great Taste White
            [
                'product_id' => 2,
                'variant_type_id' => 1, // Sachet
                'measure_value' => 20,
                'measure_unit_id' => 1, // g
                'conversion_rate' => 1,
                'price' => 6.00,
                'current_qty' => 150,
                'critical_level' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'variant_type_id' => 2, // Box
                'measure_value' => 12,
                'measure_unit_id' => 4, // pcs
                'conversion_rate' => 12,
                'price' => 70.00,
                'current_qty' => 40,
                'critical_level' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Tang Mango Powder
            [
                'product_id' => 3,
                'variant_type_id' => 1, // Sachet
                'measure_value' => 25,
                'measure_unit_id' => 1, // g
                'conversion_rate' => 1,
                'price' => 12.00,
                'current_qty' => 80,
                'critical_level' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'variant_type_id' => 2, // Box
                'measure_value' => 20,
                'measure_unit_id' => 4, // pcs
                'conversion_rate' => 20,
                'price' => 220.00,
                'current_qty' => 25,
                'critical_level' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Minute Maid Orange
            [
                'product_id' => 4,
                'variant_type_id' => 3, // Bottle
                'measure_value' => 300,
                'measure_unit_id' => 2, // ml
                'conversion_rate' => 1,
                'price' => 25.00,
                'current_qty' => 120,
                'critical_level' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 4,
                'variant_type_id' => 3, // Bottle
                'measure_value' => 500,
                'measure_unit_id' => 2, // ml
                'conversion_rate' => 1,
                'price' => 35.00,
                'current_qty' => 80,
                'critical_level' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 4,
                'variant_type_id' => 4, // Pack
                'measure_value' => 6,
                'measure_unit_id' => 4, // pcs
                'conversion_rate' => 6,
                'price' => 140.00,
                'current_qty' => 20,
                'critical_level' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
