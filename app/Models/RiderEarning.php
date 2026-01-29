<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiderEarning extends Model
{
    protected $fillable = [
        'rider_id',
        'order_id',
        'amount',
        'distance_km',
    ];
}
