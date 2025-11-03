<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users (assuming at least 2 users exist from UserSeeder)
        $users = User::all();
        if ($users->isEmpty()) {
            // If no users exist, create a dummy user ID for seeding
            // In production, UserSeeder should run first
            return;
        }

        // Get products
        $products = Product::where('status', 'active')->get();
        if ($products->isEmpty()) {
            return;
        }

        $transactions = [];

        // Create transactions over the past 30 days
        $now = Carbon::now();
        
        // For each product, create some initial stock-in transactions
        foreach ($products as $product) {
            $baseCostPrice = $product->price * 0.65; // Assume 65% of selling price as cost
            
            // Initial stock-in (when product was first added)
            $initialDate = $now->copy()->subDays(rand(20, 30));
            $initialQuantity = rand(100, 200);
            
            $transactions[] = [
                'product_id' => $product->id,
                'type' => 'in',
                'quantity' => $initialQuantity,
                'cost_price' => round($baseCostPrice, 2),
                'total_amount' => round($baseCostPrice * $initialQuantity, 2),
                'user_id' => $users->random()->id,
                'created_at' => $initialDate,
                'updated_at' => $initialDate,
            ];

            // Some stock-in transactions over time
            $stockInCount = rand(2, 4);
            for ($i = 0; $i < $stockInCount; $i++) {
                $date = $now->copy()->subDays(rand(1, 25));
                $quantity = rand(20, 80);
                $costVariation = $baseCostPrice * (1 + (rand(-10, 10) / 100)); // ±10% price variation
                
                $transactions[] = [
                    'product_id' => $product->id,
                    'type' => 'in',
                    'quantity' => $quantity,
                    'cost_price' => round($costVariation, 2),
                    'total_amount' => round($costVariation * $quantity, 2),
                    'user_id' => $users->random()->id,
                    'created_at' => $date,
                    'updated_at' => $date,
                ];
            }

            // Some stock-out transactions (sales)
            $stockOutCount = rand(3, 6);
            for ($i = 0; $i < $stockOutCount; $i++) {
                $date = $now->copy()->subDays(rand(1, 20));
                $quantity = rand(5, 30);
                $costVariation = $baseCostPrice * (1 + (rand(-5, 5) / 100)); // Smaller variation for sales
                
                $transactions[] = [
                    'product_id' => $product->id,
                    'type' => 'out',
                    'quantity' => $quantity,
                    'cost_price' => round($costVariation, 2),
                    'total_amount' => round($costVariation * $quantity, 2),
                    'user_id' => $users->random()->id,
                    'created_at' => $date,
                    'updated_at' => $date,
                ];
            }
        }

        // Sort transactions by date to ensure chronological order
        usort($transactions, function ($a, $b) {
            return $a['created_at'] <=> $b['created_at'];
        });

        // Insert transactions
        foreach ($transactions as $transaction) {
            Transaction::create($transaction);
        }

        // After creating transactions, update product stock quantities based on transactions
        // This ensures products have realistic stock levels
        foreach ($products as $product) {
            $totalIn = Transaction::where('product_id', $product->id)
                ->where('type', 'in')
                ->sum('quantity');
            
            $totalOut = Transaction::where('product_id', $product->id)
                ->where('type', 'out')
                ->sum('quantity');
            
            $calculatedStock = $totalIn - $totalOut;
            
            // Only update if calculated stock is positive and reasonable
            if ($calculatedStock >= 0 && $calculatedStock <= 1000) {
                $product->stock_quantity = $calculatedStock;
                $product->save();
            }
        }
    }
}
