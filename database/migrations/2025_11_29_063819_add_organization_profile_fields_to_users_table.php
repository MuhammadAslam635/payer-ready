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
        Schema::table('users', function (Blueprint $table) {
            $table->string('organization_type')->nullable()->after('business_name');
            $table->string('dba_name')->nullable()->after('organization_type');
            $table->string('tax_id')->nullable()->after('dba_name');
            $table->string('website')->nullable()->after('tax_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['organization_type', 'dba_name', 'tax_id', 'website']);
        });
    }
};
