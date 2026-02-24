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
        Schema::create('approval_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dual_approval_id')->constrained('dual_approval_requests')->cascadeOnDelete();

            $table->foreignId('actor_id')->constrained('users');

            $table->string('event');
            // requested, approved_level_1, approved_level_2, executed

            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_audit_logs');
    }
};
