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
        Schema::create('doctor_references', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_profile_id')->constrained('doctor_profiles')->onDelete('cascade');
            $table->string('reference_full_name');
            $table->string('reference_title');
            $table->string('reference_specialty');
            $table->string('organization_name');
            $table->string('phone');
            $table->string('email');
            $table->string('relationship_type');
            $table->integer('years_known');
            $table->string('status')->default('pending'); // pending, verified, declined
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_references');
    }
};

