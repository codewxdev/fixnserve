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
        Schema::create('security_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('event_type');

            $table->integer('risk_score')->default(0);
            $table->boolean('is_anomaly')->default(false);

            $table->json('event_data')->nullable();

            $table->string('ip_address')->nullable();
            $table->string('device')->nullable();

            $table->timestamp('occurred_at');

            $table->index(['user_id']);
            $table->index(['event_type']);
            $table->index(['risk_score']);
            $table->string('device_fingerprint')->nullable(); // optional but powerful

            // Location (optional but useful)
            $table->string('country')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Session tracking
            $table->string('session_id')->nullable();

            // Security
            $table->string('checksum')->nullable(); // tamper-proof
            $table->boolean('is_flagged')->default(false); // manual review flag
            $table->boolean('is_flagged')->default(false); // manual review flag
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_audit_logs');
    }
};
