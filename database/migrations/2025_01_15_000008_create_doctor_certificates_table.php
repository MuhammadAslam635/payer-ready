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
        Schema::create('doctor_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_profile_id')->constrained('doctor_profiles')->onDelete('cascade');
            $table->foreignId('certificate_type_id')->constrained('certificate_types');
            $table->string('certificate_name');
            $table->string('issuing_organization');
            $table->date('issue_date');
            $table->date('expiration_date')->nullable();
            $table->string('certificate_number')->nullable();
            $table->boolean('is_current')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_certificates');
    }
};






