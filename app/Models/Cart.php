<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Cart extends Model
{

    protected $guarded = [];

    public $incrementing = false;

    function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Anonymous'
        ]);
    }

    function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }

    protected static function booted()
    {
        static::creating(function (Cart $cart) {
            $cart->id = Str::uuid();
        });
    }
}
