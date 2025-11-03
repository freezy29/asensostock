<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update any NULL abbreviations with a default based on name
        DB::table('units')
            ->whereNull('abbreviation')
            ->update(['abbreviation' => DB::raw('LOWER(LEFT(REPLACE(name, " ", ""), 10))')]);

        // Make the column NOT NULL and add unique index
        Schema::table('units', function (Blueprint $table) {
            $table->string('abbreviation')->nullable(false)->change();
        });

        // Add unique index if it doesn't exist
        Schema::table('units', function (Blueprint $table) {
            $table->unique('abbreviation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropUnique(['abbreviation']);
            $table->string('abbreviation')->nullable()->change();
        });
    }
};
