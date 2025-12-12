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
        Schema::create('user_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Payment Method Type
            $table->enum('payment_method', ['card', 'jazzcash', 'easypaisa', 'bank_transfer']);

            // Common Fields for All Payment Methods
            $table->string('payment_title')->nullable(); // e.g., "My Personal Card", "Office JazzCash"
            $table->boolean('is_default')->default(false);
            $table->enum('status', ['active', 'inactive', 'pending'])->default('active');

            // ========== CARD PAYMENT FIELDS ==========
            $table->string('card_holder_name')->nullable();
            $table->string('card_number')->nullable(); // Last 4 digits or encrypted
            $table->string('card_type')->nullable(); // visa, mastercard, etc.
            $table->string('expiry_month', 2)->nullable();
            $table->string('expiry_year', 4)->nullable();
            $table->string('cvv_hash')->nullable(); // Hashed CVV (never store plain)
            $table->string('card_brand')->nullable(); // Visa, MasterCard, etc.

            // ========== JAZZCASH FIELDS ==========
            $table->string('jazzcash_account_number')->nullable(); // Mobile number
            $table->string('jazzcash_account_title')->nullable();
            $table->string('jazzcash_cnic')->nullable(); // CNIC associated
            $table->string('jazzcash_email')->nullable();

            // ========== EASYPASA/EASYPAISA FIELDS ==========
            $table->string('easypaisa_account_number')->nullable(); // Mobile number
            $table->string('easypaisa_account_title')->nullable();
            $table->string('easypaisa_cnic')->nullable(); // CNIC associated
            $table->string('easypaisa_email')->nullable();

            // ========== BANK TRANSFER FIELDS ==========
            $table->string('bank_name')->nullable();
            $table->string('account_title')->nullable();
            $table->string('account_number')->nullable();
            $table->string('iban')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('branch_name')->nullable();

            // ========== AUDIT FIELDS ==========
            $table->string('last_four_digits')->nullable(); // For cards
            $table->string('fingerprint')->nullable(); // Unique fingerprint for security
            $table->json('metadata')->nullable(); // Additional data in JSON

            $table->softDeletes();

            // Indexes for performance
            $table->index(['user_id', 'is_default']);
            $table->index(['user_id', 'payment_method']);
            $table->index('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_payments');
    }
};
