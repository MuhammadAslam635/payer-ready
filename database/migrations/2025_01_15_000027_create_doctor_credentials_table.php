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
        Schema::create('doctor_credentials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_profile_id')->constrained('doctor_profiles')->onDelete('cascade');
            $table->string('credential_type'); // license, certificate, education, training, etc.
            $table->string('credential_name');
            $table->string('issuing_organization');
            $table->string('credential_number')->nullable();
            $table->date('issue_date');
            $table->date('expiration_date')->nullable();
            $table->string('status')->default('active'); // active, expired, suspended, revoked
            $table->string('state')->nullable(); // For state-specific credentials
            $table->text('description')->nullable();
            $table->json('metadata')->nullable(); // Additional credential-specific data
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->text('verification_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_credentials');
    }
};
