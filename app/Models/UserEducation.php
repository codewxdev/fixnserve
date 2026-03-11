<?php

namespace App\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEducation extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'user_educations';

    public array $translatable = ['school', 'degree', 'diploma', 'description',
    ];

    protected $fillable = [
        'user_id',
        'school',
        'degree',
        'diploma',
        'expected_diploma_date',
        'description',
    ];

    protected $dates = [
        'expected_diploma_date',
    ];

    /**
     * Get the user that owns the education.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
