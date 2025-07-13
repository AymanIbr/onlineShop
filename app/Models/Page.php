<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Page extends Model
{
    protected $guarded = [];

    protected $casts = [
    'active' => 'boolean',
];


    protected static function booted()
    {
        static::creating(function (Page $page) {
            $page->slug = Str::slug($page->name);
        });
        static::updating(function (Page $page) {
            $page->slug = Str::slug($page->name);
        });
    }
}
