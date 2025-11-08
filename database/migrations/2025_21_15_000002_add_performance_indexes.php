<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add indexes to products table
        Schema::table('products', function (Blueprint $table) {
            $table->index('status');
            $table->index('stock_quantity');
            $table->index(['status', 'stock_quantity']); // Composite index for common queries
        });

        // Add indexes to transactions table
        Schema::table('transactions', function (Blueprint $table) {
            $table->index('created_at');
            $table->index('type');
            $table->index('user_id');
            $table->index(['type', 'created_at']); // Composite index for filtered date queries
            $table->index(['product_id', 'created_at']); // Composite index for product transaction history
        });

        // Add indexes to categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->index('status');
        });

        // Add indexes to units table
        Schema::table('units', function (Blueprint $table) {
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['stock_quantity']);
            $table->dropIndex(['status', 'stock_quantity']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['type']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['type', 'created_at']);
            $table->dropIndex(['product_id', 'created_at']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('units', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
    }
};

