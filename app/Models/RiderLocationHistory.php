<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiderLocationHistory extends Model
{
    protected $fillable = [
        'rider_id',
        'order_id',
        'latitude',
        'longitude',
        'recorded_at',
    ];
}
