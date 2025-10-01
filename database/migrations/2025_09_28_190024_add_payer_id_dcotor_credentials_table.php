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
            $table->unsignedBigInteger('payer_id')->constrained('payers')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_credentials', function (Blueprint $table) {
            $table->unsignedBigInteger('payer_id')->constrained('payers')->nullable();
        });
    }
};
