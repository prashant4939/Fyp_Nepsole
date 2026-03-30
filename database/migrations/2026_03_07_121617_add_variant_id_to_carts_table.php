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
        // Check if column already exists
        $hasColumn = DB::select("SHOW COLUMNS FROM carts LIKE 'product_variant_id'");
        
        if (empty($hasColumn)) {
            Schema::table('carts', function (Blueprint $table) {
                // Add variant_id column
                $table->foreignId('product_variant_id')->nullable()->after('product_id')->constrained('product_variants')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Drop variant_id column
            $table->dropForeign(['product_variant_id']);
            $table->dropColumn('product_variant_id');
        });
    }
};
