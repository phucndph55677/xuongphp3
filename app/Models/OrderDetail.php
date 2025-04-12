<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'product_variant_id',
        'order_id',
        'price',
        'quantity',
    ];

    public function product_variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function product()
    {
        return $this->hasOneThrough(Product::class, ProductVariant::class, 'id', 'id', 'product_variant_id', 'product_id');
    }
    public function color()
    {
        return $this->hasOneThrough(Color::class, ProductVariant::class, 'id', 'id', 'product_variant_id', 'color_id');
    }
    public function size()
    {
        return $this->hasOneThrough(Size::class, ProductVariant::class, 'id', 'id', 'product_variant_id', 'size_id');
    }
}