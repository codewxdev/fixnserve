<?php

namespace App\Domains\Audit\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class CodReconciliation extends Model
{
    use HasTranslations;

    public array $translatable = ['notes', 'variance'];

    protected $fillable = [
        'cod_ref', 'rider_id', 'rider_ref',
        'order_id', 'order_ref',
        'collected_amount', 'expected_amount', 'variance',
        'status', 'collected_at', 'deposited_at',
        'due_at', 'is_overdue', 'notes', 'translations',
    ];

    protected $casts = [
        'collected_at' => 'datetime',
        'deposited_at' => 'datetime',
        'due_at' => 'datetime',
        'is_overdue' => 'boolean',
        'translations' => 'array',
    ];

    public function scopeOverdue($query)
    {
        return $query->where('is_overdue', true)
            ->where('status', '!=', 'reconciled');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
