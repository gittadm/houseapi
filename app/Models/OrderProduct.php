<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        'count', 'order_id', 'product_id'
    ];

    protected $casts = [
        'count' => 'integer',
        'order_id' => 'integer',
        'product_id' => 'integer'
    ];
}