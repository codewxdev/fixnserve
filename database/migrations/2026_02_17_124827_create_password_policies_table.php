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
        Schema::create('password_policies', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('min_length')->default(8);
            $table->boolean('require_uppercase')->default(false);
            $table->boolean('require_symbols')->default(false);
            $table->boolean('prevent_reuse')->default(false);
            $table->boolean('check_breached')->default(false);
            $table->boolean('force_rotation_days')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_policies');
    }
};
