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
        Schema::create('organization_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('role_id')->constrained('roles');
            $table->string('position_title')->nullable();
            $table->string('department')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            // Ensure a user can only have one primary organization
            $table->unique(['user_id', 'is_primary'], 'unique_primary_organization');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_staff');
    }
};
