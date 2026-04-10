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
        // ✅ 1. SLA Tracking
        Schema::create('sla_trackings', function (Blueprint $table) {
            $table->id();
            $table->string('trackable_type');          // complaint, appeal, refund
            $table->unsignedBigInteger('trackable_id');
            $table->string('case_ref');                // CASE-2024-001
            $table->enum('sla_level', [
                'standard',
                'priority',
                'legal',
            ])->default('standard');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('first_response_due')->nullable();
            $table->timestamp('resolution_due')->nullable();
            $table->timestamp('first_response_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->boolean('first_response_breached')->default(false);
            $table->boolean('resolution_breached')->default(false);
            $table->integer('breach_count')->default(0);
            $table->integer('escalation_level')->default(0);
            // 0=support, 1=senior_ops, 2=finance, 3=legal
            $table->enum('current_assignee_role', [
                'support_agent',
                'senior_ops',
                'finance',
                'legal',
            ])->default('support_agent');
            $table->foreignId('current_assignee_id')
                ->nullable()
                ->constrained('users');
            $table->json('escalation_history')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index(['trackable_type', 'trackable_id']);
            $table->index('sla_level');
            $table->index('resolution_due');
            $table->index('resolution_breached');
        });

        // ✅ 2. Escalation Rules
        Schema::create('escalation_rules', function (Blueprint $table) {
            $table->id();
            $table->string('rule_key')->unique();
            $table->string('from_role');              // support_agent
            $table->string('to_role');                // senior_ops
            $table->integer('trigger_after_hours');   // escalate after X hours
            $table->enum('trigger_on', [
                'breach',           // when SLA breaches
                'approaching',      // 1hr before breach
                'manual',           // admin manually triggers
            ]);
            $table->boolean('auto_escalate')->default(true);
            $table->boolean('notify_supervisor')->default(true);
            $table->boolean('is_active')->default(true);
            $table->json('translations')->nullable();
            $table->timestamps();
        });

        // ✅ 3. Escalation Events Log
        Schema::create('escalation_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sla_tracking_id')
                ->constrained('sla_trackings');
            $table->string('from_role');
            $table->string('to_role');
            $table->foreignId('from_assignee')
                ->nullable()->constrained('users');
            $table->foreignId('to_assignee')
                ->nullable()->constrained('users');
            $table->enum('trigger_type', [
                'auto_breach',
                'auto_approaching',
                'manual',
            ]);
            $table->text('notes')->nullable();
            $table->foreignId('triggered_by')
                ->nullable()->constrained('users');
            $table->json('translations')->nullable();
            $table->timestamps();
        });

        // ✅ 4. SLA Level Configs
        Schema::create('sla_level_configs', function (Blueprint $table) {
            $table->id();
            $table->string('level')->unique();         // standard, priority, legal
            $table->string('label');
            $table->integer('first_response_hours');
            $table->integer('resolution_hours');
            $table->integer('approaching_alert_hours'); // alert X hours before breach
            $table->boolean('requires_supervisor')->default(false);
            $table->boolean('requires_legal_review')->default(false);
            $table->json('translations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sla_escalation');
    }
};
