<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountCoupon extends Model
{
    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];
}
