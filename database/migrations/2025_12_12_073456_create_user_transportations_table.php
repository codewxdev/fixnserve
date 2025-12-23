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
        Schema::create('user_transportations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Transportation type fields (all default false)
            $table->boolean('bicycle')->default(false);
            $table->boolean('car')->default(false);
            $table->boolean('scooter')->default(false);
            $table->boolean('truck')->default(false);
            $table->boolean('walk')->default(false);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_transportations');
    }
};
