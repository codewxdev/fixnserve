<?php

namespace App\Domains\Config\Models;

use Illuminate\Database\Eloquent\Model;

class Geofence extends Model
{
    protected $fillable = [
        'zone_name', 'type', 'boundary_type',
        'coordinates', 'radius_km',
        'center_lat', 'center_lng',
        'details', 'status',

    ];

    protected $casts = [
        'coordinates' => 'array',
        'details' => 'array',
        'status' => 'boolean',
        'radius_km' => 'decimal:2',
        'center_lat' => 'decimal:7',
        'center_lng' => 'decimal:7',

    ];
}
