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
        // Drop foreign key constraints first
        Schema::table('organization_staff', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
        });
        
        Schema::table('user_roles', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
        });
        
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
        });

        // Drop the tables
        Schema::dropIfExists('e_signature_records');
        Schema::dropIfExists('organizations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate organizations table
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('tax_id')->nullable();
            $table->string('npi')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Recreate e_signature_records table
        Schema::create('e_signature_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('document_type');
            $table->text('signature_text');
            $table->json('signature_data')->nullable();
            $table->timestamp('signed_at');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });

        // Recreate foreign key constraints
        Schema::table('organization_staff', function (Blueprint $table) {
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });
        
        Schema::table('user_roles', function (Blueprint $table) {
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });
        
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });
    }
};
