<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultancyProfile extends Model
{
    protected $fillable = [
        'user_id',
        'currency_id',
        'fee_15',
        'fee_30',
        'fee_45',
        'fee_60',
        'is_online',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'is_online',
    ];

    public function days()
    {
        return $this->hasMany(ConsultantWeekDay::class);
    }
}
