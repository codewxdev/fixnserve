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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wallet_id');     // Reference to wallet
            $table->unsignedBigInteger('user_id');       // Who performed transaction
            $table->enum('type', ['credit', 'debit']);  // Transaction type
            $table->decimal('amount', 15, 2);            // Transaction amount
            $table->text('description')->nullable();     // Optional note
            $table->unsignedBigInteger('reference_id')->nullable(); // Optional: order/invoice/etc
            $table->enum('status', ['pending', 'success', 'failed'])->default('success');
            $table->timestamps();

            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
