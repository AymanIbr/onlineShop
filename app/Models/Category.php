<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $guarded = [];

    protected $appends = ['image_path'];

    function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    function sub_categories()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }

    function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function getImagePathAttribute()
    {
        $url = asset('backend/img/100x80.svg');
        if ($this->image) {
            $url = asset('storage/' . $this->image->path);
        }

        return $url;
    }

    // public function getStatusAttribute()
    // {
    //     return $this->active ? 'Active' : 'Disabled';
    // }

    protected static function booted()
    {
        static::creating(function (Category $category) {
            $category->slug = Str::slug($category->name);
        });

        static::updating(function (Category $category) {
            $category->slug = Str::slug($category->name);
        });
    }
}
