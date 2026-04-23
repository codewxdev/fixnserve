<?php

namespace App\Domains\Audit\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class SecurityAnomaly extends Model
{
    use HasTranslations;

    public array $translatable = ['anomaly_type', 'description'];

    protected $fillable = [
        'anomaly_id', 'user_id', 'user_ref',
        'ip_address', 'anomaly_type', 'description',
        'confidence_score', 'severity', 'status',
        'evidence', 'auto_actioned',
        'auto_action_taken', 'reviewed_by', 'translations',
    ];

    protected $casts = [
        'evidence' => 'array',
        'auto_actioned' => 'boolean',
        'translations' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public static function generateId(): string
    {
        $year = now()->year;
        $count = self::whereYear('created_at', $year)->count() + 1;

        return 'ANO-'.$year.'-'.str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['detected', 'investigating']);
    }

    public function scopeCritical($query)
    {
        return $query->where('severity', 'critical');
    }
}
