<?php

use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });



Route::name('site.')->controller(FrontController::class)->group(function () {

    Route::get('/', 'index')->name('index');
    Route::get('/shop/{categorySlug?}/{subCategorySlug?}', 'shop')->name('shop');
    Route::get('/product/{product:slug}', 'product')->name('product');
});
