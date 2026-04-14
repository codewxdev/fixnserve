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
        // ✅ 1. Collusion Rings
        Schema::create('collusion_rings', function (Blueprint $table) {
            $table->id();
            $table->string('ring_id')->unique();      // RING-2291
            $table->enum('ring_type', [
                'fake_job_completion_loop',
                'rider_vendor_collusion',
                'review_manipulation',
                'provider_customer_collusion',
                'delivery_fee_farming',
            ]);
            $table->integer('confidence_score');       // 0-100
            $table->integer('actors_count')->default(0);
            $table->text('fraud_pattern_detail');
            $table->enum('status', [
                'detected',
                'investigating',
                'confirmed',
                'false_positive',
                'resolved',
            ])->default('detected');
            $table->enum('system_enforcement', [
                'none',
                'ranking_suppressed',
                'shadow_ban',
                'investigation_opened',
                'reviews_quarantined',
                'payouts_frozen',
                'bulk_ban',
            ])->default('none');
            $table->boolean('is_active')->default(true);
            $table->json('meta')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index('ring_type');
            $table->index('status');
            $table->index('confidence_score');
        });

        // ✅ 2. Ring Actors (Members)
        Schema::create('collusion_ring_actors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ring_id')->constrained('collusion_rings')->cascadeOnDelete();
            $table->string('entity_type');            // customer, rider, vendor, provider
            $table->unsignedBigInteger('entity_id');
            $table->string('entity_ref');             // C-882, P-104
            $table->string('role')->nullable();        // initiator, participant
            $table->json('evidence')->nullable();      // specific evidence per actor
            $table->boolean('is_shadow_banned')->default(false);
            $table->boolean('ranking_suppressed')->default(false);
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index('ring_id');
            $table->index(['entity_type', 'entity_id']);
        });

        // ✅ 3. Interaction Graph
        Schema::create('interaction_graphs', function (Blueprint $table) {
            $table->id();
            $table->string('actor_a_type');
            $table->unsignedBigInteger('actor_a_id');
            $table->string('actor_b_type');
            $table->unsignedBigInteger('actor_b_id');
            $table->string('interaction_type');        // job, delivery, review, payment
            $table->integer('interaction_count')->default(1);
            $table->decimal('avg_completion_time', 8, 2)->nullable(); // minutes
            $table->boolean('shared_gps')->default(false);
            $table->boolean('no_chat_history')->default(false);
            $table->integer('anomaly_score')->default(0);
            $table->boolean('is_suspicious')->default(false);
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index(['actor_a_type', 'actor_a_id']);
            $table->index(['actor_b_type', 'actor_b_id']);
            $table->index('is_suspicious');
        });

        // ✅ 4. Investigation Cases
        Schema::create('collusion_investigations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ring_id')->constrained('collusion_rings');
            $table->foreignId('opened_by')->constrained('users');
            $table->text('notes')->nullable();
            $table->enum('status', [
                'open',
                'in_progress',
                'closed',
            ])->default('open');
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->timestamp('closed_at')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collusion_detection');
    }
};
