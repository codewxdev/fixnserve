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
        Schema::create('payment_abuse_detections', function (Blueprint $table) {
            $table->id();
            // Entity Info
            $table->string('entity_type');           // customer, rider, provider
            $table->unsignedBigInteger('entity_id');
            $table->string('entity_ref');             // C-8821, R-109, P-334

            // Transaction Info
            $table->string('transaction_type');       // withdrawal, topup, payout, cod
            $table->decimal('amount', 12, 2);
            $table->string('transaction_ref')->nullable();

            // Abuse Detection
            $table->enum('abuse_pattern', [
                'refund_wallet_loop',
                'cod_manipulation',
                'chargeback_clustering',
                'rapid_topup',
                'rapid_withdrawal',
                'payout_fraud',
                'velocity_breach',
            ]);
            $table->text('pattern_detail')->nullable(); // "3 cancelled orders within 1 hour"
            $table->integer('confidence_score');        // 0-100 (98% match)
            $table->enum('severity', [
                'low', 'medium', 'high', 'critical',
            ])->default('medium');

            // Auto Action Applied
            $table->enum('auto_action', [
                'none',
                'wallet_freeze',
                'payout_delay',
                'manual_review',
                'suspend_dispatch',
                'block_cod',
            ])->default('none');

            $table->enum('status', [
                'detected',
                'under_review',
                'confirmed',
                'false_positive',
                'resolved',
            ])->default('detected');

            $table->boolean('finance_module_updated')->default(false);
            $table->json('meta')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index(['entity_type', 'entity_id']);
            $table->index('abuse_pattern');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_abuse_tables');
    }
};
