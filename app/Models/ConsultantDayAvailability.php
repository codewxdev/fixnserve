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

    public function weekDay()
    {
        return $this->belongsTo(ConsultantWeekDay::class);
    }
}
