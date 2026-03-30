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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('business_name');
            $table->string('citizenship_certificate'); // File path
            $table->string('pan_number', 20)->unique();
            $table->string('company_registration_certificate'); // File path
            $table->string('tax_certificate')->nullable(); // File path
            $table->enum('business_type', [
                'sole_proprietorship',
                'partnership', 
                'private_limited',
                'llp',
                'other'
            ]);
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_active')->default(true);
            $table->text('deactivation_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};