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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('question_text');
            $table->text('description')->nullable();
            $table->string('question_type')->default('text'); // text, textarea, select, radio, checkbox, date
            $table->json('options')->nullable(); // For select, radio, checkbox options
            $table->boolean('is_required')->default(false);
            $table->integer('sort_order')->default(0);
            $table->string('category')->default('general');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};






