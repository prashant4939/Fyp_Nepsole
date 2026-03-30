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
        Schema::table('brands', function (Blueprint $table) {
            // Make description nullable if it exists
            if (Schema::hasColumn('brands', 'description')) {
                $table->text('description')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            // Make description required again
            if (Schema::hasColumn('brands', 'description')) {
                $table->text('description')->nullable(false)->change();
            }
        });
    }
};