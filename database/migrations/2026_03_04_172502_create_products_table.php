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
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('stock');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->text('product_details')->nullable();
            $table->text('size_and_fit')->nullable();
            $table->text('handle_and_care')->nullable();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
            $table->string('size', 50)->nullable(); // Single size or comma-separated
            $table->string('color', 50)->nullable(); // Single color or comma-separated
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sold')->default(0);
            $table->timestamps();

            // Indexes for better performance
            $table->index(['vendor_id', 'is_active']);
            $table->index(['category_id', 'is_active']);
            $table->index(['brand_id', 'is_active']);
            $table->index('is_active');
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