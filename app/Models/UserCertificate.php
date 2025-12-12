<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCertificate extends Model
{
    use HasFactory;

    protected $table = 'user_certificates';

    protected $fillable = [
        'user_id',
        'image',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor for full image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/'.$this->image);
        }

        return null;
    }
}
