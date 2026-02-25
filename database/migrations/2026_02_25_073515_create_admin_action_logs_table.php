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
        Schema::create('admin_action_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('admin_id');
            $table->string('admin_role');

            $table->string('action_type');
            $table->string('target_type')->nullable();
            $table->unsignedBigInteger('target_id')->nullable();

            $table->json('before_state')->nullable();
            $table->json('after_state')->nullable();

            $table->string('reason_code');

            $table->string('ip_address');
            $table->string('device_fingerprint')->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamp('performed_at');

            $table->index(['admin_id']);
            $table->index(['action_type']);
            $table->index(['performed_at']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_action_logs');
    }
};
