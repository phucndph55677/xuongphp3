<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vorcher extends Model
{
    protected $fillable = [
        'name',
        'code',
        'type',
        'sale_price',
        'min_price',
        'max_price',
        'quntity',
        'start_date',
        'end_date'
    ];
}
