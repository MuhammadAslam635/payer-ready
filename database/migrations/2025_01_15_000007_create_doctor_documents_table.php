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
        Schema::create('doctor_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_profile_id')->constrained('doctor_profiles')->onDelete('cascade');
            $table->foreignId('document_type_id')->constrained('document_types');
            $table->string('original_filename');
            $table->string('stored_filename');
            $table->string('file_path');
            $table->bigInteger('file_size_bytes');
            $table->string('mime_type');
            $table->string('file_hash');
            $table->date('upload_date');
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->integer('version')->default(1);
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
        Schema::dropIfExists('doctor_documents');
    }
};

