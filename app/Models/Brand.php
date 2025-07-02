<?php

namespace App\Models;

use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $guarded = [];


    function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }

    protected static function booted()
    {
        static::creating(function (Brand $brand) {
            $brand->slug = Str::slug($brand->name);
        });

        static::updating(function (Brand $brand) {
            if ($brand->isDirty('name')) {
                $brand->slug = Str::slug($brand->name);
            }
        });
    }
}
