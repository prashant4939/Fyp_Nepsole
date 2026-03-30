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
            $table->foreignId('product_image_id')->constrained('product_images')->onDelete('cascade');
            $table->string('size', 20); // e.g., 6, 7, 8, 9, 10, 11, 12
            $table->unsignedInteger('stock')->default(0);
            $table->timestamps();

            // Unique constraint: one size per image
            $table->unique(['product_image_id', 'size']);
            
            // Index for better performance
            $table->index('product_image_id');
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
