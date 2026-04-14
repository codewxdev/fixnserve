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
        // ✅ 1. Refund Requests
        Schema::create('refund_requests', function (Blueprint $table) {
            $table->id();
            $table->string('refund_id')->unique();        // REF-2024-001
            $table->foreignId('complaint_id')
                ->nullable()
                ->constrained('complaints');

            // Entity
            $table->string('entity_type');               // customer, rider
            $table->unsignedBigInteger('entity_id');
            $table->string('entity_ref');                // C-199

            // Order/Transaction
            $table->string('order_ref')->nullable();     // ORD-1092
            $table->string('transaction_ref')->nullable();

            // Refund Details
            $table->enum('refund_type', [
                'wallet',
                'original_payment_method',
                'store_credit',
                'cod_adjustment',
            ]);
            $table->decimal('original_amount', 12, 2);
            $table->decimal('requested_amount', 12, 2);
            $table->decimal('approved_amount', 12, 2)->default(0);
            $table->decimal('service_completion_percent', 5, 2)->default(0);

            // Calculation Factors
            $table->json('calculation_breakdown')->nullable();
            $table->integer('fraud_risk_score')->default(0);
            $table->decimal('evidence_weight', 5, 2)->default(0);

            // Status
            $table->enum('status', [
                'pending',
                'calculating',
                'pending_approval',
                'approved',
                'rejected',
                'processing',
                'completed',
                'failed',
                'escalated',
            ])->default('pending');

            // Approval
            $table->boolean('requires_finance_approval')->default(false);
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->foreignId('rejected_by')->nullable()->constrained('users');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();

            // PSP
            $table->string('psp_transaction_id')->nullable();
            $table->string('psp_status')->nullable();
            $table->timestamp('processed_at')->nullable();

            $table->text('notes')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index(['entity_type', 'entity_id']);
            $table->index('status');
            $table->index('refund_type');
        });

        // ✅ 2. Refund Policies
        Schema::create('refund_policies', function (Blueprint $table) {
            $table->id();
            $table->string('policy_key')->unique();
            $table->string('label');
            $table->decimal('max_auto_approve_amount', 12, 2)->default(1000);
            $table->decimal('finance_approval_threshold', 12, 2)->default(5000);
            $table->integer('max_refunds_per_month')->default(3);
            $table->decimal('fraud_score_block_threshold', 5, 2)->default(70);
            $table->json('completion_refund_matrix')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('translations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refund_requests');
        Schema::dropIfExists('refund_policies');
    }
};
