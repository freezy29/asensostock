<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Beverages', 'status' => 'active'],
            ['name' => 'Snacks', 'status' => 'active'],
            ['name' => 'Household Items', 'status' => 'active'],
            ['name' => 'Personal Care', 'status' => 'active'],
            ['name' => 'Food & Condiments', 'status' => 'active'],
            ['name' => 'Dairy Products', 'status' => 'active'],
            ['name' => 'Frozen Goods', 'status' => 'active'],
            ['name' => 'Cleaning Supplies', 'status' => 'active'],
            ['name' => 'Canned Goods', 'status' => 'active'],
            ['name' => 'Bakery Items', 'status' => 'active'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
