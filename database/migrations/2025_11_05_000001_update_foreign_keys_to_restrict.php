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
        // products: category_id and unit_id -> restrict on delete
        Schema::table('products', function (Blueprint $table) {
            // Drop existing foreign keys
            $table->dropForeign(['category_id']);
            $table->dropForeign(['unit_id']);

            // Re-add with restrictOnDelete
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->restrictOnDelete();

            $table->foreign('unit_id')
                ->references('id')->on('units')
                ->restrictOnDelete();
        });

        // transactions: product_id and user_id -> restrict on delete
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->restrictOnDelete();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to cascadeOnDelete
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['unit_id']);

            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->cascadeOnDelete();

            $table->foreign('unit_id')
                ->references('id')->on('units')
                ->cascadeOnDelete();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->cascadeOnDelete();
        });
    }
};
