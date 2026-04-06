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
        Schema::create('payment_velocity_limits', function (Blueprint $table) {
            $table->id();
            $table->string('limit_key')->unique();    // topups_per_day, withdrawals_per_day
            $table->string('label');
            $table->integer('max_count');             // Max 5
            $table->decimal('max_amount', 12, 2)->nullable();
            $table->string('window');                 // 24h, 1h, 7d
            $table->boolean('is_active')->default(true);
            $table->json('translations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_velocity_limits');
    }
};
