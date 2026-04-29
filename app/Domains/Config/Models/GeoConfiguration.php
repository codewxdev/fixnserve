<?php

namespace App\Domains\Config\Models;

use Illuminate\Database\Eloquent\Model;

class GeoConfiguration extends Model
{
    protected $fillable = [
        'map_provider',
        'distance_calculation_mode',
        'default_service_radius',
        'emergency_geo_lock',

    ];

    protected $casts = [
        'emergency_geo_lock' => 'boolean',
        'default_service_radius' => 'decimal:2',
    ];
}
