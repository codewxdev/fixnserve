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
        Schema::create('rider_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('rider_id')->constrained('users');

            $table->enum('status', ['pending', 'accepted', 'rejected', 'expired'])->default('pending');
            // pending | accepted | rejected | expired

            $table->dateTime('sent_at')->useCurrent();
            $table->dateTime('responded_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rider_requests');
    }
};
