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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('organization_id')->nullable()->constrained('organizations');
            $table->string('type'); // payment, refund, credit, debit
            $table->string('status'); // pending, completed, failed, cancelled
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('payment_method')->nullable(); // credit_card, bank_transfer, etc.
            $table->string('payment_gateway')->nullable(); // stripe, paypal, etc.
            $table->string('gateway_transaction_id')->nullable();
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};






