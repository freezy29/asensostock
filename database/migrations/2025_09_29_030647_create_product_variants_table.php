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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('variant_type_id')->constrained()->cascadeOnDelete();
            $table->decimal('measure_value', total: 8, places: 2);
            $table->foreignId('measure_unit_id')->constrained()->cascadeOnDelete();
            $table->integer('conversion_rate')->nullable();
            $table->decimal('price', total: 10, places: 2);
            $table->integer('current_qty');
            $table->integer('critical_level');
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
        Schema::dropIfExists('product_variants');
    }
};
