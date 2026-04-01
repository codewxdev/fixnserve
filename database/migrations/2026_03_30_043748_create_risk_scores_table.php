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
        Schema::create('risk_scores', function (Blueprint $table) {
            $table->id();
            $table->string('entity_type');        // customer, rider, vendor
            $table->unsignedBigInteger('entity_id');
            $table->integer('score')->default(0); // 0-100
            $table->enum('tier', [
                'low',      // 0-30
                'medium',   // 31-65
                'high',     // 66-89
                'critical',  // 90-100
            ])->default('low');
            $table->json('reason_codes')->nullable(); // ['device_reuse', 'payment_failure']
            $table->json('signal_breakdown')->nullable(); // each signal score
            $table->timestamp('last_event_at')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();
            $table->unique(['entity_type', 'entity_id']);
            $table->index(['tier', 'score']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_scoring_tables');
    }
};
