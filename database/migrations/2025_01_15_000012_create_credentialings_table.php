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
        Schema::create('credentialings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_profile_id')->constrained('doctor_profiles')->onDelete('cascade');
            $table->foreignId('organization_id')->constrained('organizations')->onDelete('cascade');
            $table->string('status')->default('pending'); // pending, in_review, approved, rejected, expired
            $table->date('application_date');
            $table->date('review_start_date')->nullable();
            $table->date('review_end_date')->nullable();
            $table->date('approval_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->text('review_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->json('required_documents')->nullable(); // List of required documents
            $table->json('submitted_documents')->nullable(); // List of submitted documents
            $table->json('missing_documents')->nullable(); // List of missing documents
            $table->boolean('is_urgent')->default(false);
            $table->integer('priority_level')->default(1); // 1=normal, 2=high, 3=urgent
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credentialings');
    }
};






