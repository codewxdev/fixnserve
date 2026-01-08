<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultantWeekDay extends Model
{
    protected $fillable = ['user_id', 'day', 'is_enabled'];

    protected $hidden = ['created_at', 'updated_at'];

    public function availabilities()
    {
        return $this->hasMany(ConsultantDayAvailability::class);
    }
}
