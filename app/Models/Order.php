<?php

namespace App\Models;

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
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rider()
    {
        return $this->belongsTo(User::class, 'rider_id');
    }
}
