<?php

namespace App\Models;

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
        'fax_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
