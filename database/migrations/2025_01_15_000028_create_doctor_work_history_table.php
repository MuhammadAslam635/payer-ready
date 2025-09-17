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
        Schema::create('doctor_work_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_profile_id')->constrained('doctor_profiles')->onDelete('cascade');
            $table->string('organization_name');
            $table->string('position_title');
            $table->string('department')->nullable();
            $table->foreignId('work_address_id')->nullable()->constrained('addresses');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->string('supervisor_name')->nullable();
            $table->string('supervisor_phone')->nullable();
            $table->text('description')->nullable();
            $table->text('responsibilities')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_work_history');
    }
};
