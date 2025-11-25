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
        Schema::table('doctor_credentials', function (Blueprint $table) {
            if (!Schema::hasColumn('doctor_credentials', 'submitted_at')) {
                $table->timestamp('submitted_at')->nullable()->after('payer_id');
            }
            if (!Schema::hasColumn('doctor_credentials', 'effective_date')) {
                $table->date('effective_date')->nullable()->after('submitted_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_credentials', function (Blueprint $table) {
            if (Schema::hasColumn('doctor_credentials', 'submitted_at')) {
                $table->dropColumn('submitted_at');
            }
            if (Schema::hasColumn('doctor_credentials', 'effective_date')) {
                $table->dropColumn('effective_date');
            }
        });
    }
};
