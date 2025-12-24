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
        Schema::create('consultancy_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained()->cascadeOnDelete(); // PKR
            $table->decimal('fee_15', 10, 2)->default(0);
            $table->decimal('fee_30', 10, 2)->default(0);
            $table->decimal('fee_45', 10, 2)->default(0);
            $table->decimal('fee_60', 10, 2)->default(0);
            $table->boolean('is_online')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consiltancy_profiles');
    }
};
