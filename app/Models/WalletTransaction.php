<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'user_id',
        'type',           // credit / debit
        'amount',
        'description',
        'reference_id',   // optional, order/invoice id
        'status',         // pending / success / failed
    ];

    protected $hidden = ['created_at', 'updated_at'];

    // ===== Relationships =====
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
