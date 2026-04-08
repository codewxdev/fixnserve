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
        // ✅ 1. Complaints Table
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('case_id')->unique();        // CASE-2024-001

            // Source
            $table->enum('source', [
                'customer_app',
                'provider_app',
                'vendor_app',
                'rider_app',
                'support_agent',
                'auto_generated',
            ]);
            $table->string('reporter_type')->nullable(); // customer, provider
            $table->unsignedBigInteger('reporter_id')->nullable();
            $table->string('reporter_ref')->nullable();  // C-199, P-44

            // Related Entity
            $table->string('related_entity_id')->nullable(); // ORD-1092
            $table->string('related_entity_type')->nullable(); // order, job, payment

            // Classification
            $table->enum('classification', [
                'service_quality',
                'delivery_issues',
                'payment_issues',
                'fraud_allegations',
                'behavior_misconduct',
                'system_failure',
            ]);
            $table->boolean('is_auto_classified')->default(true);
            $table->text('dispute_reason');              // "Order marked delivered but not received"
            $table->text('initial_notes')->nullable();

            // Severity & SLA
            $table->enum('severity', [
                'low',
                'medium',
                'high',
                'critical',
            ])->default('medium');
            $table->integer('sla_hours');                // SLA in hours
            $table->timestamp('sla_deadline')->nullable();
            $table->boolean('sla_breached')->default(false);

            // Status
            $table->enum('status', [
                'unassigned',
                'assigned',
                'in_progress',
                'resolved',
                'closed',
                'escalated',
            ])->default('unassigned');

            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->timestamp('assigned_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');

            $table->json('classification_meta')->nullable(); // AI/rule confidence
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('severity');
            $table->index('classification');
            $table->index('sla_deadline');
            $table->index(['reporter_type', 'reporter_id']);
        });

        // ✅ 2. Classification Rules
        Schema::create('classification_rules', function (Blueprint $table) {
            $table->id();
            $table->string('rule_key')->unique();
            $table->string('classification');            // delivery_issues
            $table->json('keywords');                    // ["not received", "not delivered"]
            $table->enum('severity', ['low', 'medium', 'high', 'critical']);
            $table->integer('sla_hours');
            $table->integer('priority')->default(0);     // higher = check first
            $table->boolean('is_active')->default(true);
            $table->json('translations')->nullable();
            $table->timestamps();
        });

        // ✅ 3. SLA Configs
        Schema::create('sla_configs', function (Blueprint $table) {
            $table->id();
            $table->string('severity')->unique();        // critical, high, medium, low
            $table->integer('response_hours');           // first response time
            $table->integer('resolution_hours');         // full resolution time
            $table->boolean('auto_escalate')->default(true);
            $table->integer('escalate_after_hours');
            $table->json('translations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaint_intake');
    }
};
