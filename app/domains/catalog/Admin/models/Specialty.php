<?php

namespace App\Domains\Catalog\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $fillable = ['subcategory_id', 'name'];

    public function sub_specialties()
    {
        return $this->hasMany(SubSpecialty::class, 'specialty_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
