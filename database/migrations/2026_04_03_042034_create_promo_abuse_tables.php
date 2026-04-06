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
        // ✅ 1. Promo Abuse Detections
        Schema::create('promo_abuse_detections', function (Blueprint $table) {
            $table->id();

            // Entity
            $table->string('entity_type');           // customer, provider
            $table->unsignedBigInteger('entity_id');
            $table->string('entity_ref');             // C-9921, P-105

            // Promo Info
            $table->string('promo_code')->nullable(); // REF-ALI-123, WELCOME50
            $table->string('promo_type');             // referral, discount, onboarding, cashback
            $table->decimal('promo_amount', 10, 2)->default(0);

            // Abuse Detection
            $table->enum('abuse_pattern', [
                'self_referral',
                'fake_interaction',
                'promo_stacking',
                'multiple_accounts_device',
                'new_user_old_card',
                'referral_loop',
                'velocity_abuse',
            ]);
            $table->text('pattern_detail')->nullable();
            $table->integer('confidence_score');       // 0-100

            // System Action
            $table->enum('system_action', [
                'promo_invalidated',
                'reward_clawback',
                'promo_dropped',
                'account_restricted',
                'promo_blocked',
            ])->default('promo_invalidated');

            $table->enum('status', [
                'detected',
                'actioned',
                'false_positive',
                'resolved',
            ])->default('detected');

            $table->decimal('clawback_amount', 10, 2)->default(0);
            $table->json('meta')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index(['entity_type', 'entity_id']);
            $table->index('abuse_pattern');
            $table->index('status');
        });

        // ✅ 2. Promo Rules Config
        Schema::create('promo_abuse_rules', function (Blueprint $table) {
            $table->id();
            $table->string('rule_key')->unique();     // max_promos_per_device
            $table->string('label');
            $table->string('action');                 // block, invalidate, reject
            $table->boolean('is_active')->default(true);
            $table->json('config')->nullable();        // rule specific config
            $table->json('translations')->nullable();
            $table->timestamps();
        });

        // ✅ 3. Referral Graph
        Schema::create('referral_graphs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referrer_id');
            $table->unsignedBigInteger('referee_id');
            $table->string('device_hash')->nullable(); // same device detection
            $table->string('ip_address')->nullable();
            $table->boolean('same_device')->default(false);
            $table->boolean('same_ip')->default(false);
            $table->boolean('is_suspicious')->default(false);
            $table->enum('status', [
                'valid',
                'suspicious',
                'invalidated',
            ])->default('valid');
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index('referrer_id');
            $table->index('referee_id');
            $table->index('is_suspicious');
        });

        // ✅ 4. Promo Usage Tracking
        Schema::create('promo_usage_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('promo_code');
            $table->string('device_hash')->nullable();
            $table->string('ip_address')->nullable();
            $table->boolean('was_blocked')->default(false);
            $table->string('block_reason')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('promo_code');
            $table->index('device_hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_abuse_tables');
    }
};
