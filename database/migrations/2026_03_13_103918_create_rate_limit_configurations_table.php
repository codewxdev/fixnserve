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
        Schema::create('rate_limit_configurations', function (Blueprint $table) {
            $table->id();

            // Global & API Controls
            $table->integer('api_rate_limit')->default(1000);  // requests/minute
            $table->integer('burst_limit')->default(50);        // requests/second

            // Entity Restrictions
            $table->integer('per_user_limit')->default(60);    // requests/minute
            $table->integer('per_ip_limit')->default(120);     // requests/minute

            // Channel Specific
            $table->integer('sms_limit')->default(20);         // msgs/minute
            $table->integer('push_limit')->default(100);       // msgs/minute
            $table->integer('email_limit')->default(50);       // msgs/minute

            // Emergency
            $table->boolean('emergency_throttling')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rate_limit_configurations');
    }
};
