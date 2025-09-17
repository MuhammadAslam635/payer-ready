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
        Schema::create('doctor_licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_profile_id')->constrained('doctor_profiles')->onDelete('cascade');
            $table->foreignId('license_type_id')->constrained('license_types');
            $table->string('license_number');
            $table->string('state');
            $table->date('issue_date');
            $table->date('expiration_date');
            $table->string('status')->default('active'); // active, expired, suspended, revoked
            $table->string('issuing_authority');
            $table->boolean('is_primary')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_licenses');
    }
};

