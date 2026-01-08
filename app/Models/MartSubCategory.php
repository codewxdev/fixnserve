<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MartSubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'mart_category_id',
        'name',
        'description',
        'status',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function category()
    {
        return $this->belongsTo(MartCategory::class, 'mart_category_id');
    }
}
