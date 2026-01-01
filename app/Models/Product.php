<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku_no',
        'category_id',
        'sub_category_id',
        'quantity',
        'description',
        'image',
        'price',
        'user_id',
    ];

    public function category()
    {
        return $this->belongsTo(MartCategory::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(MartSubCategory::class, 'sub_category_id');
    }
}
