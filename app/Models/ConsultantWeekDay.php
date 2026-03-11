<?php

namespace App\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class ConsultantWeekDay extends Model
{
    use HasTranslations;

    public array $translatable = ['day'];

    protected $fillable = ['user_id', 'day', 'is_enabled'];

    protected $hidden = ['created_at', 'updated_at'];

    public function consultant()
    {
        return $this->belongsTo(User::class, 'consultant_id');
    }

    public function dayAvailabilities()
    {
        return $this->hasMany(
            ConsultantDayAvailability::class,
            'consultant_week_day_id'
        );
    }
}
