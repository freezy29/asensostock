<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Optimistic locking version column
            $table->unsignedBigInteger('version')->default(0)->after('status');
        });

        // Add check constraint for non-negative stock (MySQL 8+ enforces CHECK)
        DB::statement('ALTER TABLE products ADD CONSTRAINT chk_products_stock_non_negative CHECK (stock_quantity >= 0)');
    }

    public function down(): void
    {
        // Drop constraint then column (order matters)
        try {
            DB::statement('ALTER TABLE products DROP CONSTRAINT chk_products_stock_non_negative');
        } catch (\Throwable $e) {
            // Some MySQL variants use different syntax
            try {
                DB::statement('ALTER TABLE products DROP CHECK chk_products_stock_non_negative');
            } catch (\Throwable $e2) {
                // ignore
            }
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('version');
        });
    }
};
