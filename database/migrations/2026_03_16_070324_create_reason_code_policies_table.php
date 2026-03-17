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
        Schema::create('reason_code_policies', function (Blueprint $table) {
            $table->id();
            $table->enum('enforcement_level', ['none', 'moderate', 'strict'])
                ->default('moderate');
            $table->json('translations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reason_code_policies');
    }
};
