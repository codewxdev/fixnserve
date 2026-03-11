<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Promotion extends Model
{
    use HasTranslations;

    public array $translatable = ['name',
         ];

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
