<?php

namespace App\Models;

use App\Domains\Security\Models\User;
use Illuminate\Database\Eloquent\Model;

class BusinessDoc extends Model
{
    protected $fillable = [
        'business_name',
        'owner_name',
        'business_type',
        'location',
        'email',
        'tax_id',
        'registration_number',
        'permit_number',
        'permit_document',
        'tax_certificate',
        'bank_statement',
        'other_licenses',
        'user_id',
        'status',
        'verified_by',
        'fax_number',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
