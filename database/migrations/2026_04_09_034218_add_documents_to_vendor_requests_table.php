<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendor_requests', function (Blueprint $table) {
            $table->string('citizenship_photo')->nullable()->after('address');
            $table->string('tax_clearance')->nullable()->after('citizenship_photo');
            $table->string('business_document')->nullable()->after('tax_clearance');
        });
    }

    public function down(): void
    {
        Schema::table('vendor_requests', function (Blueprint $table) {
            $table->dropColumn(['citizenship_photo', 'tax_clearance', 'business_document']);
        });
    }
};
