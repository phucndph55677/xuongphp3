<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 
        'icon'
    ];

    // Quan he 1 - 1
    public function product()
    {
        return $this->hasOne(Product::class);
    }

    // Quan he 1 - n
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
