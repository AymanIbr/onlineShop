<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubCategory extends Model
{
    protected $guarded = [];
    protected $appends = ['image_path'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    function products()
    {
        return $this->hasMany(Product::class, 'sub_category_id', 'id');
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
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
        static::creating(function (SubCategory $sub_category) {
            $sub_category->slug = Str::slug($sub_category->name);
        });

        static::updating(function (SubCategory $sub_category) {
            if ($sub_category->isDirty('name')) {
                $sub_category->slug = Str::slug($sub_category->name);
            }
        });
    }
}
