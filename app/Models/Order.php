<?php

namespace App\Models;

use App\Domains\Security\Models\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'rider_id',
        'status',
        'pickup_lat',
        'pickup_lng',
        'drop_lat',
        'drop_lng',
        'distance_km',
        'estimated_time',
        'picked_up_at',
        'transport_type_id',
        'delivered_at',
    ];

    // customer
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // rider
    public function rider()
    {
        return $this->belongsTo(User::class, 'rider_id');
    }
}
