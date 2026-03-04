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
        Schema::create('feature_flag_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feature_flag_id');
            $table->foreignId('changed_by');
            $table->json('old_value');
            $table->json('new_value');
            $table->timestamps();
            $table->foreign('feature_flag_id')->references('id')->on('feature_flags')->onDelete('cascade');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_flag_logs');
    }
};
