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
        Schema::table('products', function (Blueprint $table) {
            // Remove color field as we're selling shoes only
            $table->dropColumn('color');
            
            // Remove size field as sizes will be managed per image variant
            $table->dropColumn('size');
            
            // Remove stock field as stock will be managed per variant
            $table->dropColumn('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('color', 50)->nullable();
            $table->string('size', 50)->nullable();
            $table->unsignedInteger('stock')->default(0);
        });
    }
};
