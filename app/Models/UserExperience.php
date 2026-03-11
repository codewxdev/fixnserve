<?php

namespace App\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class UserExperience extends Model
{
    use HasTranslations;

    public array $translatable = ['position', 'company', 'description',
    ];

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
