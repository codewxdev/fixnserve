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
        Schema::create('risk_enforcements', function (Blueprint $table) {
            $table->id();
            $table->string('entity_type');
            $table->unsignedBigInteger('entity_id');
            $table->enum('action', [
                'monitoring',        // just watch
                'restrict_features', // limit access
                'wallet_freeze',     // freeze wallet
                'account_suspend',   // suspend account
                'flag_review',       // manual review needed
            ]);
            $table->enum('trigger', [
                'auto',   // system triggered
                'manual',  // admin triggered
            ])->default('auto');
            $table->integer('risk_score');          // score at time of enforcement
            $table->string('reason')->nullable();
            $table->foreignId('enforced_by')->nullable()->constrained('users');
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('translations')->nullable();
            $table->timestamps();
            $table->index(['entity_type', 'entity_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_enforcements_tables');
    }
};
