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
        Schema::create('doctor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('npi_number')->nullable();
            $table->string('dea_number')->nullable();
            $table->string('caqh_id')->nullable();
            $table->string('status')->default('pending'); // pending, active, inactive, suspended
            $table->foreignId('primary_specialty_id')->nullable()->constrained('specialties');
            $table->integer('experience_years')->nullable();
            $table->boolean('board_certified')->default(false);
            $table->date('board_certification_date')->nullable();
            $table->text('bio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_profiles');
    }
};






