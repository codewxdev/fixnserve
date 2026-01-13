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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_id')->constrained()->cascadeOnDelete();
            $table->foreignId('provider_id')->constrained('users');
            $table->foreignId('subscription_plan_id')->constrained();
            // $table->string('tier');
            $table->enum('subscription_status', [
                'active',
                'grace',
                'suspended',
                'cancelled',
            ]);
            // $table->enum('billing_cycle', ['monthly', 'yearly']);
            $table->boolean('auto_renew')->default(true);
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('grace_ends_at')->nullable();
            $table->timestamps();

            $table->unique(
                ['app_id', 'provider_id'],
                'one_subscription_per_app'
            );
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
