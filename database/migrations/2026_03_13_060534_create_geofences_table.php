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
        Schema::create('geofences', function (Blueprint $table) {
            $table->id();
            $table->string('zone_name');
            $table->enum('type', ['service_area', 'restricted_zone', 'surcharge_zone']);
            $table->enum('boundary_type', ['polygon', 'radius']);
            $table->json('coordinates')->nullable();  // polygon points
            $table->decimal('radius_km', 8, 2)->nullable(); // for radius type
            $table->decimal('center_lat', 10, 7)->nullable();
            $table->decimal('center_lng', 10, 7)->nullable();
            $table->json('details')->nullable(); // fare multiplier, fee, restrictions
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geofences');
    }
};
