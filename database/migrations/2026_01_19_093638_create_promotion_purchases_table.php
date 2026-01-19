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
        Schema::create('promotion_purchases', function (Blueprint $table) {
            $table->id();

            $table->foreignId('app_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('promotion_id')->constrained()->cascadeOnDelete();
            $table->foreignId('promotion_slot_id')->constrained('promotion_slots')->cascadeOnDelete();

            // Make timestamps nullable
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->boolean('is_active')->default(false);

            $table->decimal('amount_paid', 10, 2);
            $table->string('currency', 10)->default('PKR');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('payment_reference')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->json('meta')->nullable();

            $table->timestamps();

            $table->index(['app_id', 'is_active']);
            $table->index(['promotion_id', 'promotion_slot_id']);
            $table->index(['payment_status']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_purchases');
    }
};
