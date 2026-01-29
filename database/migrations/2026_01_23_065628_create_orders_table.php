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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // customer
            $table->foreignId('rider_id')
                ->nullable()
                ->constrained('users'); // rider (role=rider)
            $table->enum('status',['pending','searching','assigned','picked_up','delivered','cancelled'])->default('pending');
            // pending | searching | assigned | picked_up | delivered | cancelled
            $table->decimal('pickup_lat', 10, 7);
            $table->decimal('pickup_lng', 10, 7);
            $table->decimal('drop_lat', 10, 7);
            $table->decimal('drop_lng', 10, 7);
            $table->decimal('distance_km', 8, 2)->nullable();
            $table->integer('estimated_time')->nullable(); // minutes
            $table->dateTime('picked_up_at')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
