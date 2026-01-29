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
        Schema::create('rider_location_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rider_id')->constrained('users');
            $table->foreignId('order_id')->nullable()->constrained();

            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);

            $table->timestamp('recorded_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rider_location_histories');
    }
};
