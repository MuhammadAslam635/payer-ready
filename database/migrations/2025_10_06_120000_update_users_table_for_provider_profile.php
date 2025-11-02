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
            // Add new fields for provider profile only if they don't exist
            if (!Schema::hasColumn('users', 'provider_type')) {
                $table->string('provider_type')->nullable()->after('name'); // MD, DO, NP, PA, ABA, etc.
            }
            if (!Schema::hasColumn('users', 'ssn_encrypted')) {
                $table->string('ssn_encrypted')->nullable()->after('provider_type');
            }
            if (!Schema::hasColumn('users', 'fax_number')) {
                $table->string('fax_number')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'taxonomy_code')) {
                $table->string('taxonomy_code')->nullable()->after('npi_number'); // e.g., 261QM0801X
            }
            if (!Schema::hasColumn('users', 'nppes_login')) {
                $table->string('nppes_login')->nullable()->after('pecos_password');
            }
            if (!Schema::hasColumn('users', 'nppes_password')) {
                $table->string('nppes_password')->nullable()->after('nppes_login');
            }
            if (!Schema::hasColumn('users', 'availity_login')) {
                $table->string('availity_login')->nullable()->after('nppes_password');
            }
            if (!Schema::hasColumn('users', 'availity_password')) {
                $table->string('availity_password')->nullable()->after('availity_login');
            }
            
            // Remove fields that are no longer needed (check if they exist first)
            if (Schema::hasColumn('users', 'middle_name')) {
                $table->dropColumn('middle_name');
            }
            if (Schema::hasColumn('users', 'dea_number')) {
                $table->dropColumn('dea_number');
            }
            if (Schema::hasColumn('users', 'dea_expiration_date')) {
                $table->dropColumn('dea_expiration_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add back removed fields
            $table->string('middle_name')->nullable()->after('name');
            $table->string('dea_number')->nullable()->after('npi_number');
            $table->date('dea_expiration_date')->nullable()->after('dea_number');
            
            // Remove new fields
            $table->dropColumn([
                'provider_type',
                'ssn_encrypted', 
                'fax_number',
                'taxonomy_code',
                'nppes_login',
                'nppes_password',
                'availity_login',
                'availity_password'
            ]);
        });
    }
};
