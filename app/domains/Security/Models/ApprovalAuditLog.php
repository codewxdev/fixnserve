<?php

namespace App\Domains\Security\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class ApprovalAuditLog extends Model
{
    use HasTranslations;

    public array $translatable = ['event', 'ip_address', 'user_agent'];

    protected $fillable = [
        'dual_approval_id',
        'actor_id',
        'event',
        'ip_address',
        'user_agent',
    ];

    public function dualApproval()
    {
        return $this->belongsTo(DualApproval::class);
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    protected $hidden = ['created_at', 'updated_at'];
}
