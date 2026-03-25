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
        Schema::create('time_bound_privileges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_admin_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('granted_by_id')->constrained('users');

            // ✅ Use Spatie role_id instead of custom roles
            $table->foreignId('role_id')->constrained('roles');

            $table->timestamp('expires_at');
            $table->boolean('is_active')->default(true);
            $table->timestamp('revoked_at')->nullable();
            $table->foreignId('revoked_by_id')->nullable()->constrained('users');
            $table->json('translations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_bound_privileges');
    }
};
