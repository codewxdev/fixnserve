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

        // ✅ 2. Privilege Usage Logs

        Schema::create('privilege_usage_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('user_role');
            $table->enum('action_type', [
                'bulk_export',
                'data_access',
                'user_impersonation',
                'config_change',
                'financial_override',
                'account_modification',
                'permission_change',
                'sensitive_report',
                'emergency_override',
                'bulk_action',
            ]);
            $table->string('resource_type');             // user, order, wallet
            $table->unsignedBigInteger('resource_id')->nullable();
            $table->string('resource_ref')->nullable();
            $table->text('description');
            $table->string('ip_address')->nullable();
            $table->string('endpoint')->nullable();
            $table->boolean('is_authorized')->default(true);
            $table->boolean('is_suspicious')->default(false);
            $table->json('before_state')->nullable();
            $table->json('after_state')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('action_type');
            $table->index('is_suspicious');
            $table->index('resource_type');
        });

        // ✅ 3. Security Anomalies

        Schema::create('security_anomalies', function (Blueprint $table) {
            $table->id();
            $table->string('anomaly_id')->unique();       // ANO-2024-001
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_ref')->nullable();
            $table->string('ip_address')->nullable();
            $table->enum('anomaly_type', [
                'brute_force',
                'credential_stuffing',
                'impossible_travel',
                'concurrent_sessions',
                'unusual_time_access',
                'mass_data_access',
                'privilege_abuse',
                'token_replay',
                'device_anomaly',
                'geo_anomaly',
            ]);
            $table->text('description');
            $table->integer('confidence_score');
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])
                ->default('medium');
            $table->enum('status', [
                'detected',
                'investigating',
                'confirmed',
                'false_positive',
                'resolved',
            ])->default('detected');
            $table->json('evidence')->nullable();
            $table->boolean('auto_actioned')->default(false);
            $table->string('auto_action_taken')->nullable();
            $table->foreignId('reviewed_by')
                ->nullable()->constrained('users');
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('anomaly_type');
            $table->index('severity');
            $table->index('status');
        });

        // ✅ 4. Access Policy Changes

        Schema::create('access_policy_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('changed_by')->constrained('users');
            $table->enum('policy_type', [
                'ip_block',
                'ip_allow',
                'ip_remove',
                'device_block',
                'device_trust',
                'device_remove',
                'geo_restriction',
                'rate_limit_change',
                'mfa_policy',
                'session_policy',
            ]);
            $table->string('target_value');              // IP address, device fingerprint
            $table->string('target_type');               // ip, device, user
            $table->unsignedBigInteger('target_user_id')->nullable();
            $table->json('old_value')->nullable();
            $table->json('new_value')->nullable();
            $table->text('reason')->nullable();
            $table->string('ip_address')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();

            $table->index('changed_by');
            $table->index('policy_type');
            $table->index('target_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_audit');
    }
};
