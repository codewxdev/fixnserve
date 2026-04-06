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
        Schema::create('payment_threat_patterns', function (Blueprint $table) {
            $table->id();
            $table->string('pattern_key')->unique();  // refund_wallet_loop
            $table->string('name');                   // Refund-Wallet Loops
            $table->text('description');
            $table->enum('severity', ['low', 'medium', 'high', 'critical']);
            $table->string('auto_action');            // freeze_wallet, block_cod
            $table->boolean('is_active')->default(true);
            $table->json('detection_rules')->nullable(); // rules config
            $table->json('translations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_threat_patterns');
    }
};
