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
