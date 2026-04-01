<?php

namespace App\Domains\Fraud\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class GeoVelocityAlert extends Model
{
    use HasTranslations;

    protected $fillable = [
        'user_id',
        'from_city',
        'from_country',
        'to_city',
        'to_country',
        'from_lat',
        'from_lng',
        'to_lat',
        'to_lng',
        'time_diff_minutes',
        'distance_km',
        'is_impossible',
        'risk_level',
        'status',
        'translations',
    ];

    protected $casts = [
        'is_impossible' => 'boolean',
        'translations' => 'array',
    ];

    // ✅ Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ Scopes
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeCritical($query)
    {
        return $query->where('risk_level', 'critical');
    }
}
