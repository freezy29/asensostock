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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->foreignId('product_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_unit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_packaging_id')->constrained(
                table: 'product_packaging',
                indexName: 'id'
            );
            $table->decimal('price', total: 10, places: 2);
            $table->integer('current_stock')->default(0);
            $table->integer('reorder_level')->default(10);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
