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
        Schema::create('device_policies', function (Blueprint $table) {
            $table->id();
            $table->integer('max_trusted_devices')->default(5);
            $table->integer('trust_expiration_days')->nullable(); // null = no expiry
            $table->boolean('require_otp_new_device')->default(true);
            $table->boolean('block_rooted_devices')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_policies');
    }
};
