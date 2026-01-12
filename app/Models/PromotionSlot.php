<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionSlot extends Model
{
    protected $fillable = [
        'promotion_id',
        'total_slots',
        'used_slots',
    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
}
