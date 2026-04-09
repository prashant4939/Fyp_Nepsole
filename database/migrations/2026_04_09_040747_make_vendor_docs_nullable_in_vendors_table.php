<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('citizenship_certificate')->nullable()->change();
            $table->string('company_registration_certificate')->nullable()->change();
            $table->string('pan_number')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('citizenship_certificate')->nullable(false)->change();
            $table->string('company_registration_certificate')->nullable(false)->change();
            $table->string('pan_number')->nullable(false)->change();
        });
    }
};
