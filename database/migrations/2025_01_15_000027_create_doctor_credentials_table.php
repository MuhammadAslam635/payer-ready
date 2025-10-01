<?php

use App\Enums\CredentialRequest;
use App\Enums\CredentialType;
use App\Enums\CredentialStatus;
use App\Enums\State;
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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('request_type', CredentialRequest::values())->nullable(); 
            $table->string('credential_name')->nullable();
            $table->string('issuing_organization')->nullable();
            $table->string('credential_number')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->string('status')->default(CredentialStatus::ACTIVE->value); // active, expired, suspended, revoked
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('cascade'); // For state-specific credentials
            $table->text('description')->nullable();
            $table->json('metadata')->nullable(); // Additional credential-specific data
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullable();
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
