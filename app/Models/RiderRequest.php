<?php

namespace App\Models;

use App\Domains\Security\Models\User;
use Illuminate\Database\Eloquent\Model;

class RiderRequest extends Model
{
    protected $fillable = [
        'order_id',
        'rider_id',
        'status',
        'sent_at',
        'responded_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function rider()
    {
        return $this->belongsTo(User::class, 'rider_id');
    }
}
