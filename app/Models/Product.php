<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Product extends Model
{
    protected $guarded = [];
    protected $appends = ['image_path'];

    protected $casts = [
        'active' => 'boolean',
        'track_qty' => 'boolean',
    ];

    function image()
    {
        return $this->morphOne(Image::class, 'imageable')->withDefault([
            'path' => 'uploads/' . 'no-image.svg'
        ])->where('type', 'main');
    }

    function gallery()
    {
        return $this->morphMany(Image::class, 'imageable')->where('type', 'gallery');
    }

    function category()
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'Uncategoriez'
        ]);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'product_id')->where('status',1);
    }


    public function getImagePathAttribute()
    {
        $url = asset('admin-assets/img/100x80.svg');
        if ($this->image) {
            $url = asset('storage/' . $this->image->path);
        }
        return $url;
    }

    protected static function booted()
    {
        static::creating(function (Product $product) {
            $product->slug = Str::slug($product->title);
        });

        static::updating(function (Product $product) {
            if ($product->isDirty('title')) {
                $product->slug = Str::slug($product->title);
            }
        });
    }
}
