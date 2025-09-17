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
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('carrier');
            $table->string('policy_number');
            $table->decimal('coverage_amount', 15, 2)->nullable();
            $table->date('effective_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurances');
    }
};
