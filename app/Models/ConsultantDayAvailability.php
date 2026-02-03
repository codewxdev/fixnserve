<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultantDayAvailability extends Model
{
    protected $fillable = [
        'consultant_week_day_id',
        'start_time',
        'end_time',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function consultantWeekDay()
    {
        return $this->belongsTo(
            ConsultantWeekDay::class,
            'consultant_week_day_id'
        );
    }

    // (Optional) bookings relation
    public function bookings()
    {
        return $this->hasMany(
            ConsultantBooking::class,
            'consultant_day_availability_id'
        );
    }
}
