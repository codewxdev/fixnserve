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
        Schema::create('subscription_entitlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_plan_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('feature_key');     // max_jobs, analytics_access
            $table->string('feature_value');   // 10, true

            $table->unique(
                ['subscription_plan_id', 'feature_key'],
                'plan_feature_unique'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_entitlements');
    }
};
