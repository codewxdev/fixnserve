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
        Schema::create('configuration_snapshots', function (Blueprint $table) {
            $table->id();
            $table->string('version_id')->unique();  // v2.4.1, v2.4.0
            $table->string('module');                // geo, rate_limits, geofences
            $table->foreignId('created_by')->constrained('users');
            $table->json('snapshot');               // full config at that time
            $table->json('changes')->nullable();    // what changed from previous
            $table->text('change_summary')->nullable(); // "Updated API rate limits"
            $table->enum('status', ['active', 'archived'])->default('archived');
            $table->boolean('is_manual')->default(false); // manual or auto snapshot
            $table->json('translations')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuration_snapshots');
    }
};
