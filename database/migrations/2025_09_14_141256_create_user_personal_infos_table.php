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
        Schema::create('user_personal_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('middle_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('ssn')->nullable();
            $table->text('home_address')->nullable();
            $table->text('practice_address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('npi_number')->nullable();
            $table->string('caqh_id')->nullable();
            $table->string('caqh_login')->nullable();
            $table->string('caqh_password')->nullable();
            $table->string('pecos_login')->nullable();
            $table->string('pecos_password')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_personal_infos');
    }
};
