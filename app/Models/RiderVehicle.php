<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiderVehicle extends Model
{
    protected $fillable = ['rider_id','transport_type_id','vehicle_number','vehicle_image','is_active'];

}
