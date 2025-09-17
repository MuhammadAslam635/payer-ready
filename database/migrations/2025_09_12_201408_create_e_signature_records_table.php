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
        Schema::create('e_signature_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('document_type')->nullable(); // provider_profile_submission, terms_agreement, etc.
            $table->string('document_version')->nullable();
            $table->string('signature_text')->nullable(); // Full name used for signature
            $table->timestamp('signature_date')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('consent_text')->nullable(); // The consent text that was agreed to
            $table->string('agreement_terms_version')->nullable();
            $table->boolean('is_valid')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_signature_records');
    }
};
