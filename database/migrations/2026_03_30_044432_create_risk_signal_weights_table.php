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
        Schema::create('risk_signal_weights', function (Blueprint $table) {
            $table->id();
            $table->string('signal_key')->unique(); // device_reuse
            $table->string('signal_label');         // Device Reuse
            $table->integer('weight');              // 0-100
            $table->enum('impact', [
                'low',
                'medium',
                'high',
            ])->default('medium');
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
        Schema::dropIfExists('risk_signal_weights_tables');
    }
};
