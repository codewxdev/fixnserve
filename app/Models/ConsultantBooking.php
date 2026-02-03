<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultantBooking extends Model
{
    protected $fillable = [
        'user_id',
        'consultant_day_availability_id',
        'booking_date',
        'start_time',
        'end_time',
        'duration',
        'fee',
    ];

    protected $casts = [
        'duration' => 'integer',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
