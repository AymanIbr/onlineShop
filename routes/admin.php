<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SubCategoryController;
use Illuminate\Support\Facades\Route;



Route::prefix('admin/dashboard')->middleware('auth:admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::resource('categories', CategoryController::class);
    // Route::post('/admin/categories/upload-image', [CategoryController::class, 'uploadImage'])->name('categories.upload');
    Route::resource('sub-categories', SubCategoryController::class);
});
