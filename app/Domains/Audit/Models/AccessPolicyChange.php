<?php

namespace App\Domains\Audit\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class AccessPolicyChange extends Model
{
    use HasTranslations;

    public array $translatable = ['reason', 'old_value', 'new_value', 'target_value', 'target_type', 'old_value'];

    protected $fillable = [
        'changed_by', 'policy_type', 'target_value',
        'target_type', 'target_user_id',
        'old_value', 'new_value', 'reason',
        'ip_address', 'translations',
    ];

    protected $casts = [
        'old_value' => 'array',
        'new_value' => 'array',
        'translations' => 'array',
    ];

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
