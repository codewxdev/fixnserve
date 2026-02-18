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
        Schema::create('auth_policies', function (Blueprint $table) {
            $table->id();
            $table->boolean('login_email_password')->default(true);
            $table->boolean('login_phone_otp')->default(false);
            $table->boolean('login_oauth')->default(false);

            $table->json('login_rules')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auth_policies');
    }
};
