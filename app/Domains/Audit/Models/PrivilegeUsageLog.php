<?php

namespace App\Domains\Audit\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class PrivilegeUsageLog extends Model
{
    use HasTranslations;

    public array $translatable = ['description'];

    protected $fillable = [
        'user_id', 'user_role', 'action_type',
        'resource_type', 'resource_id', 'resource_ref',
        'description', 'ip_address', 'endpoint',
        'is_authorized', 'is_suspicious',
        'before_state', 'after_state', 'translations',
    ];

    protected $casts = [
        'is_authorized' => 'boolean',
        'is_suspicious' => 'boolean',
        'before_state' => 'array',
        'after_state' => 'array',
        'translations' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSuspicious($query)
    {
        return $query->where('is_suspicious', true);
    }

    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}
