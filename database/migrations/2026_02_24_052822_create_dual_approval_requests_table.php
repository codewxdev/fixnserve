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
        Schema::create('dual_approval_requests', function (Blueprint $table) {
            $table->id();
            $table->string('action_type');
            // payout, refund, psp_key_update, kill_switch, subscription_override

            $table->json('payload');
            // action data (amount, user_id, key_id, etc.)

            $table->foreignId('requested_by')->constrained('users');

            $table->enum('status', [
                'pending',
                'approved_level_1',
                'approved',
                'rejected',
                'executed',
                'expired',
            ])->default('pending');

            $table->foreignId('approved_by_level_1')->nullable()->constrained('users');
            $table->timestamp('approved_at_level_1')->nullable();

            $table->foreignId('approved_by_level_2')->nullable()->constrained('users');
            $table->timestamp('approved_at_level_2')->nullable();

            $table->text('justification');

            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dual_approval_requests');
    }
};
