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
        Schema::create('kill_switches', function (Blueprint $table) {
            $table->id();

            // Scope
            $table->enum('scope', [
                'payments',
                'orders',
                'subscriptions',
                'payouts',
                'notifications',
            ]);

            // Kill type
            $table->enum('type', ['soft', 'hard']);

            // Safety
            $table->string('reason');               // mandatory justification
            $table->timestamp('expires_at')->nullable(); // auto-expiry fallback
            $table->foreignId('created_by');
            $table->enum('status', ['active', 'expired', 'cancelled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kill_switches');
    }
};
