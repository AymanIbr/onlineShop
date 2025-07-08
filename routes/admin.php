<?php

use App\Http\Controllers\Admin\BrandControllers;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiscountCodeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Models\Brand;
use Illuminate\Support\Facades\Route;



Route::prefix('admin/dashboard')->middleware('auth:admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::resource('categories', CategoryController::class);
    // Route::post('/admin/categories/upload-image', [CategoryController::class, 'uploadImage'])->name('categories.upload');
    Route::resource('sub-categories', SubCategoryController::class);
    Route::resource('brands', BrandControllers::class);
    Route::resource('products', ProductController::class);
    Route::resource('shipping', ShippingController::class);
    Route::resource('coupons', DiscountCodeController::class);
});
Route::get('/delete-image/{id?}', [ProductController::class, 'delete_img'])->name('delete_img');
Route::get('/get-subcategories/{category_id}', [ProductController::class, 'getSubCategories'])->name('get.subcategories');
