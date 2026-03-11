<?php

namespace App\Domains\Catalog\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];

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
