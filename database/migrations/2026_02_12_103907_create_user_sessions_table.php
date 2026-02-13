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
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('jwt_id')->index();          // jti
            $table->string('token')->index();           // hashed token

            $table->string('device')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('location')->nullable();

            $table->unsignedTinyInteger('risk_score')->default(0);

            $table->timestamp('last_activity_at')->nullable();
            $table->timestamp('logout_at')->nullable();

            $table->boolean('is_revoked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_sessions');
    }
};
