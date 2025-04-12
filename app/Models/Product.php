<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'code',
        'name',
        'image',
        'description',
        'metarial',
        'instruct',
        'onpage',
        'category_id'
    ];

    // Quan he n - 1 (tu san pham vao danh muc)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function  variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function getLowestPriceAttribute()
    {
        return $this->variants()->min('price');
    }

    public function getHighestPriceAttribute()
    {
        return $this->variants()->min('price');
    }

}
