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
        Schema::create('geo_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('map_provider')->default('google'); // google, mapbox, osm
            $table->string('distance_calculation_mode')->default('routing'); // routing, straight
            $table->decimal('default_service_radius', 8, 2)->default(15);
            $table->boolean('emergency_geo_lock')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geo_configurations');
    }
};
