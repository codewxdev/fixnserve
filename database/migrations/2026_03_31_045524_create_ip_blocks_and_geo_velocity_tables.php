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
        // ✅ 1. IP Blocks
        Schema::create('ip_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->unique();
            $table->enum('type', [
                'vpn', 'proxy', 'tor',
                'datacenter', 'manual', 'bot',
            ]);
            $table->string('reason')->nullable();
            $table->integer('block_count')->default(1);
            $table->foreignId('blocked_by')->nullable()->constrained('users');
            $table->boolean('is_active')->default(true);
            $table->timestamp('expires_at')->nullable();
            $table->json('translations')->nullable();
            $table->timestamps();
        });

        // ✅ 2. Geo Velocity Alerts
        Schema::create('geo_velocity_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('from_city')->nullable();
            $table->string('from_country')->nullable();
            $table->string('to_city')->nullable();
            $table->string('to_country')->nullable();
            $table->decimal('from_lat', 10, 7)->nullable();
            $table->decimal('from_lng', 10, 7)->nullable();
            $table->decimal('to_lat', 10, 7)->nullable();
            $table->decimal('to_lng', 10, 7)->nullable();
            $table->integer('time_diff_minutes');
            $table->float('distance_km');
            $table->boolean('is_impossible')->default(true);
            $table->enum('risk_level', ['medium', 'high', 'critical'])
                ->default('high');
            $table->enum('status', ['open', 'reviewed', 'dismissed'])
                ->default('open');
            $table->json('translations')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ip_blocks_and_geo_velocity_tables');
    }
};
