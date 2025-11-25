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
        Schema::table('certificate_types', function (Blueprint $table) {
            // Add new columns first
            $table->string('certificate_number')->nullable()->after('name');
            $table->date('issue_date')->nullable()->after('issuing_organization');
            $table->date('expiry_date')->nullable()->after('issue_date');
        });

        // Copy data from code to certificate_number
        DB::statement('UPDATE certificate_types SET certificate_number = code WHERE certificate_number IS NULL');

        Schema::table('certificate_types', function (Blueprint $table) {
            // Make certificate_number required and unique
            $table->string('certificate_number')->nullable(false)->unique()->change();
            
            // Drop old columns
            $table->dropColumn(['code', 'validity_years', 'default_amount']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificate_types', function (Blueprint $table) {
            // Add back old columns
            $table->string('code')->unique()->after('name');
            $table->integer('validity_years')->nullable()->after('issuing_organization');
            $table->decimal('default_amount', 8, 2)->nullable()->after('is_active');
        });

        // Copy data back from certificate_number to code
        DB::statement('UPDATE certificate_types SET code = certificate_number WHERE code IS NULL');

        Schema::table('certificate_types', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn(['certificate_number', 'issue_date', 'expiry_date']);
        });
    }
};
