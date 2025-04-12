<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = [
        'name'
    ];

    public function  varisants()
    {
        return $this->hasMany(ProductVariant::class, 'size_id');
    }
}
