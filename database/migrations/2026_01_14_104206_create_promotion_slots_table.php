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
        Schema::create('promotion_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('promotion_id');
            $table->unsignedBigInteger('app_id');

            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();

            $table->integer('max_slots');
            $table->integer('used_slots')->default(0);

            $table->decimal('visibility_weight', 5, 2);
            $table->decimal('price', 10, 2);

            $table->timestamps();

            $table->foreign('promotion_id')
                ->references('id')->on('promotions')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_slots');
    }
};
