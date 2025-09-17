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
        Schema::create('attestations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('license_suspended')->default(false);
            $table->boolean('felony_conviction')->default(false);
            $table->boolean('malpractice_claims')->default(false);
            $table->text('additional_notes')->nullable();
            $table->timestamp('attested_at')->nullable();
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
        Schema::dropIfExists('attestations');
    }
};
