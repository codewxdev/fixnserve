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
        Schema::create('token_policies', function (Blueprint $table) {
            $table->id();

            // Access token TTL (minutes)
            $table->integer('access_token_ttl_minutes')
                ->default(60);

            // Refresh token TTL (days)
            $table->integer('refresh_token_ttl_days')
                ->default(30);

            // Rotate refresh token on use
            $table->boolean('rotate_refresh_on_use')
                ->default(true);

            // Optional but recommended
            $table->integer('grace_period_seconds')
                ->default(30);

            // Optional audit fields
            $table->unsignedBigInteger('updated_by')
                ->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token_policies');
    }
};
