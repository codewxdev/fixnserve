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
        Schema::create('emergency_override_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('override_id');
            $table->foreignId('admin_id');
            $table->string('action');
            $table->json('meta')->nullable();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_override_logs');
    }
};
