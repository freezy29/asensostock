<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories and units for reference
        $categories = Category::all()->keyBy('name');
        $units = Unit::all()->keyBy('name');

        $products = [
            // Beverages
            [
                'name' => 'Coca-Cola 1.5L Bottle',
                'category_id' => $categories['Beverages']->id,
                'unit_id' => $units['Bottle']->id,
                'stock_quantity' => 45,
                'price' => 65.00,
                'critical_level' => 15,
                'status' => 'active',
            ],
            [
                'name' => 'Pepsi 500mL Bottle',
                'category_id' => $categories['Beverages']->id,
                'unit_id' => $units['Bottle']->id,
                'stock_quantity' => 60,
                'price' => 25.00,
                'critical_level' => 20,
                'status' => 'active',
            ],
            [
                'name' => 'Crystal Clear Distilled Water 500mL',
                'category_id' => $categories['Beverages']->id,
                'unit_id' => $units['Bottle']->id,
                'stock_quantity' => 120,
                'price' => 12.00,
                'critical_level' => 40,
                'status' => 'active',
            ],
            [
                'name' => 'Workers Blend Coffee 3-in-1 16g',
                'category_id' => $categories['Beverages']->id,
                'unit_id' => $units['Sachet']->id,
                'stock_quantity' => 200,
                'price' => 6.50,
                'critical_level' => 50,
                'status' => 'active',
            ],

            // Snacks
            [
                'name' => 'SkyFlakes Crackers 10s Pack',
                'category_id' => $categories['Snacks']->id,
                'unit_id' => $units['Pack']->id,
                'stock_quantity' => 35,
                'price' => 42.00,
                'critical_level' => 15,
                'status' => 'active',
            ],
            [
                'name' => 'Lucky Me Pancit Canton 60g',
                'category_id' => $categories['Snacks']->id,
                'unit_id' => $units['Piece']->id,
                'stock_quantity' => 85,
                'price' => 14.00,
                'critical_level' => 30,
                'status' => 'active',
            ],
            [
                'name' => 'Chippy Original 60g',
                'category_id' => $categories['Snacks']->id,
                'unit_id' => $units['Piece']->id,
                'stock_quantity' => 90,
                'price' => 12.00,
                'critical_level' => 25,
                'status' => 'active',
            ],
            [
                'name' => 'Nissin Cup Noodles Beef 65g',
                'category_id' => $categories['Snacks']->id,
                'unit_id' => $units['Piece']->id,
                'stock_quantity' => 65,
                'price' => 32.00,
                'critical_level' => 20,
                'status' => 'active',
            ],

            // Household Items
            [
                'name' => 'Surf Powder Detergent 45g',
                'category_id' => $categories['Household Items']->id,
                'unit_id' => $units['Sachet']->id,
                'stock_quantity' => 150,
                'price' => 8.00,
                'critical_level' => 50,
                'status' => 'active',
            ],
            [
                'name' => 'Tide Powder Detergent 380g',
                'category_id' => $categories['Household Items']->id,
                'unit_id' => $units['Box']->id,
                'stock_quantity' => 25,
                'price' => 45.00,
                'critical_level' => 10,
                'status' => 'active',
            ],
            [
                'name' => 'Plastic Wrapper 1kg',
                'category_id' => $categories['Household Items']->id,
                'unit_id' => $units['Kilogram']->id,
                'stock_quantity' => 12,
                'price' => 180.00,
                'critical_level' => 5,
                'status' => 'active',
            ],

            // Personal Care
            [
                'name' => 'Safeguard White Soap 135g',
                'category_id' => $categories['Personal Care']->id,
                'unit_id' => $units['Bar']->id,
                'stock_quantity' => 80,
                'price' => 28.00,
                'critical_level' => 25,
                'status' => 'active',
            ],
            [
                'name' => 'Dove Beauty Bar 90g',
                'category_id' => $categories['Personal Care']->id,
                'unit_id' => $units['Bar']->id,
                'stock_quantity' => 45,
                'price' => 65.00,
                'critical_level' => 15,
                'status' => 'active',
            ],
            [
                'name' => 'Colgate Toothpaste 100g',
                'category_id' => $categories['Personal Care']->id,
                'unit_id' => $units['Piece']->id,
                'stock_quantity' => 55,
                'price' => 75.00,
                'critical_level' => 18,
                'status' => 'active',
            ],

            // Food & Condiments
            [
                'name' => 'Silver Swan Soy Sauce 385mL',
                'category_id' => $categories['Food & Condiments']->id,
                'unit_id' => $units['Bottle']->id,
                'stock_quantity' => 40,
                'price' => 32.00,
                'critical_level' => 12,
                'status' => 'active',
            ],
            [
                'name' => 'Datu Puti Vinegar 385mL',
                'category_id' => $categories['Food & Condiments']->id,
                'unit_id' => $units['Bottle']->id,
                'stock_quantity' => 38,
                'price' => 28.00,
                'critical_level' => 12,
                'status' => 'active',
            ],
            [
                'name' => 'Mang Tomas All-Around Sarsa 325g',
                'category_id' => $categories['Food & Condiments']->id,
                'unit_id' => $units['Bottle']->id,
                'stock_quantity' => 30,
                'price' => 42.00,
                'critical_level' => 10,
                'status' => 'active',
            ],

            // Canned Goods
            [
                'name' => 'Century Tuna Flakes 155g',
                'category_id' => $categories['Canned Goods']->id,
                'unit_id' => $units['Can']->id,
                'stock_quantity' => 50,
                'price' => 38.00,
                'critical_level' => 15,
                'status' => 'active',
            ],
            [
                'name' => 'Purefoods Corned Beef 150g',
                'category_id' => $categories['Canned Goods']->id,
                'unit_id' => $units['Can']->id,
                'stock_quantity' => 42,
                'price' => 52.00,
                'critical_level' => 12,
                'status' => 'active',
            ],

            // One inactive product for testing
            [
                'name' => 'Discontinued Product Sample',
                'category_id' => $categories['Snacks']->id,
                'unit_id' => $units['Piece']->id,
                'stock_quantity' => 0,
                'price' => 10.00,
                'critical_level' => 5,
                'status' => 'inactive',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
