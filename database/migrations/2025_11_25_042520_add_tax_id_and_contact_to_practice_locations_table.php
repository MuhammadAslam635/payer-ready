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
        Schema::table('practice_locations', function (Blueprint $table) {
            if (!Schema::hasColumn('practice_locations', 'tax_id')) {
                $table->string('tax_id')->nullable()->after('npi_type_2');
            }
            if (!Schema::hasColumn('practice_locations', 'office_phone')) {
                $table->string('office_phone')->nullable()->after('tax_id');
            }
            if (!Schema::hasColumn('practice_locations', 'office_fax')) {
                $table->string('office_fax')->nullable()->after('office_phone');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('practice_locations', function (Blueprint $table) {
            if (Schema::hasColumn('practice_locations', 'tax_id')) {
                $table->dropColumn('tax_id');
            }
            if (Schema::hasColumn('practice_locations', 'office_phone')) {
                $table->dropColumn('office_phone');
            }
            if (Schema::hasColumn('practice_locations', 'office_fax')) {
                $table->dropColumn('office_fax');
            }
        });
    }
};
