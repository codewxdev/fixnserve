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
        Schema::create('consultant_bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('consultant_day_availability_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('booking_date');

            $table->time('start_time');
            $table->time('end_time');

            $table->enum('duration', [15, 30, 45, 60]);
            $table->decimal('fee', 10, 2);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultant_bookings');
    }
};
