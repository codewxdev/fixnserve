<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserExperience extends Model
{
    protected $fillable = [
        'user_id',
        'position',
        'company',
        'location',
        'currently_working',
        'start_date',
        'end_date',
        'description',
    ];

    protected $hidden = [

        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'currently_working' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
