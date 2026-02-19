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
        Schema::create('mfa_policies', function (Blueprint $table) {
            $table->id();
            $table->enum('enforcement_policy', [
                'off',
                'admins_only',
                'all_users',
            ])->default('admins_only');

            $table->json('allowed_methods')->nullable()->comment('List of allowed MFA methods, e.g., ["totp", "sms"]');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mfa_policies');
    }
};
