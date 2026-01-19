<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $fillable = ['subcategory_id', 'name'];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function subSpecialties()
    {
        return $this->hasMany(SubSpecialty::class);
    }
}
