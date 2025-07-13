<?php

use App\Models\Category;
use App\Models\Page;

function getCategories()
{
    return Category::orderBy("name", "ASC")
        ->withCount('products')
        ->with(['sub_categories' => function ($query) {
            $query->where('active', true)->where('show_home', true);
        }])
        ->where([
            'show_home' => true,
            'active' => true,
        ])
        ->get();
}

function staticPages()
{
    $pages = Page::orderBy('name','ASC')->get();
    return $pages;
}
