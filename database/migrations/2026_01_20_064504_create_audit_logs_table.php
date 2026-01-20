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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            // Who performed the action
            $table->foreignId('admin_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // What happened
            $table->string('action');
            // e.g: force_cancel, update_price, refund_promotion

            // On which entity
            $table->string('entity_type');
            // e.g: subscription, promotion, user

            $table->unsignedBigInteger('entity_id');

            // Before & After snapshot
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();

            // Security metadata
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamps();

            // Indexes for fast audit queries
            $table->index(['entity_type', 'entity_id']);
            $table->index('admin_id');
            $table->index('action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
