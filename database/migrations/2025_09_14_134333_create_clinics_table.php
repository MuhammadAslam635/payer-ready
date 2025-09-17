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
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('business_name')->nullable();
            $table->string('legal_business_name')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->foreignId('state_id')->nullable()->constrained()->onDelete('set null');
            $table->string('zip_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('npi_number')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes
            $table->index(['user_id', 'is_active']);
            $table->index('state_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinics');
    }
};
