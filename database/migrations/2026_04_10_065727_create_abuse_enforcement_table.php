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
        // ✅ 1. Abuse Detections
        Schema::create('abuse_detections', function (Blueprint $table) {
            $table->id();
            $table->string('entity_type');
            $table->unsignedBigInteger('entity_id');
            $table->string('entity_ref');

            $table->enum('abuse_type', [
                'refund_farming',
                'high_dispute_frequency',
                'coordinated_complaints',
                'false_claims',
                'wallet_abuse',
                'policy_violation',
            ]);

            $table->integer('confidence_score');
            $table->text('pattern_detail');
            $table->json('evidence')->nullable();

            $table->enum('severity', [
                'low', 'medium', 'high', 'critical',
            ])->default('medium');

            $table->enum('enforcement_action', [
                'warning',
                'refund_limit',
                'account_restriction',
                'wallet_lock',
                'risk_escalation',
                'permanent_ban',
            ])->default('warning');

            $table->enum('status', [
                'detected',
                'enforced',
                'appealed',
                'false_positive',
                'resolved',
            ])->default('detected');

            $table->boolean('synced_to_risk_module')->default(false);
            $table->json('meta')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index(['entity_type', 'entity_id']);
            $table->index('abuse_type');
            $table->index('status');
        });

        // ✅ 2. Enforcement Actions Log
        Schema::create('enforcement_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('abuse_detection_id')
                ->constrained('abuse_detections');
            $table->string('entity_type');
            $table->unsignedBigInteger('entity_id');
            $table->string('action_type');
            $table->text('reason');
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('enforced_by')
                ->nullable()
                ->constrained('users');
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index(['entity_type', 'entity_id']);
            $table->index('is_active');
        });

        // ✅ 3. Abuse Policies
        Schema::create('abuse_policies', function (Blueprint $table) {
            $table->id();
            $table->string('policy_key')->unique();
            $table->string('label');
            $table->integer('max_disputes_per_month')->default(5);
            $table->integer('max_refunds_per_month')->default(3);
            $table->integer('false_claim_threshold')->default(3);
            $table->decimal('refund_amount_threshold', 12, 2)->default(5000);
            $table->integer('coordinated_complaint_threshold')->default(5);
            $table->boolean('auto_enforce')->default(true);
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
        Schema::dropIfExists('abuse_enforcement');
    }
};
