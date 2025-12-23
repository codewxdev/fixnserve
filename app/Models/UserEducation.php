<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEducation extends Model
{
    use HasFactory;

    protected $table = 'user_educations';

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
