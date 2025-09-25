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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('document_type_id')->constrained('document_types')->nullable();
            $table->string('original_filename')->nullable();
            $table->string('stored_filename')->nullable();
            $table->string('file_path')->nullable();
            $table->bigInteger('file_size_bytes')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('file_hash')->nullable();
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

