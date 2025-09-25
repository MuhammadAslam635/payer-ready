<?php

use App\Enums\LicenseStatus;
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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('license_type_id')->constrained('license_types');
            $table->string('license_number')->nullable();
            $table->foreignId('state_id')->constrained('states');
            $table->date('issue_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->enum('status', array_column(LicenseStatus::cases(), 'value'))->default(LicenseStatus::ACTIVE->value);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->string('verified_by')->nullable();
            $table->text('verification_notes')->nullable();
            $table->string('issuing_authority')->nullable();
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

