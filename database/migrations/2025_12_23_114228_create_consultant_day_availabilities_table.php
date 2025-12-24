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
        Schema::create('consultant_day_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultant_week_day_id')
                ->constrained('consultant_week_days')
                ->cascadeOnDelete();

            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultant_day_availabilities');
    }
};
