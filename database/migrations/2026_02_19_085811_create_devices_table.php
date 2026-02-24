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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('device_name');
            $table->string('fingerprint')->unique();
            $table->string('os_version')->nullable();
            $table->string('app_version')->nullable();
            $table->ipAddress('last_ip')->nullable();
            $table->enum('trust_status', ['trusted', 'unverified', 'banned'])->default('unverified');
            $table->timestamp('last_seen_at')->nullable();
            $table->boolean('is_rooted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('devices');
    }
};
