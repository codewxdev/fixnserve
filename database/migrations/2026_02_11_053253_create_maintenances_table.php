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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['global', 'module', 'region']);
            $table->string('module')->nullable();       // orders, payments, etc
            $table->foreignId('country_id')->nullable(); // region-based

            // Messaging
            $table->string('reason');
            $table->text('user_message');

            // Timing
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();

            // Control
            $table->enum('status', ['scheduled', 'active', 'cancelled']);

            // Audit
            $table->foreignId('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
