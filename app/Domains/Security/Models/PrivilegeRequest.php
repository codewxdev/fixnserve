<?php

namespace App\Domains\Security\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class PrivilegeRequest extends Model
{
    use HasTranslations;

    public array $translatable = ['justification', 'scope'];

    protected $fillable = [
        'user_id',
        'requested_role',
        'scope',
        'justification',
        'status',
        'approved_by',
        'approved_at',
        'expires_at',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'scope' => 'array',
        'approved_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
