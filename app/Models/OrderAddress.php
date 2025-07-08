<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Intl\Countries;

class OrderAddress extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $appends = ['country_name'];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getCountryNameAttribute()
    {
        return Countries::getName($this->country);
    }
}
