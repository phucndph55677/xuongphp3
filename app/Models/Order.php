<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'address',
        'phone',
        'email',
        'status',
        'payment',
        'total',
        'vorcher_code',
        'sale_price',
        'pay_amount',
        'note'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
