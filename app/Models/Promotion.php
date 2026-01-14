<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'app_id',
        'name',
        'duration_hours',
        'is_active',
    ];

    public function slots()
    {
        return $this->hasMany(PromotionSlot::class);
    }
}
