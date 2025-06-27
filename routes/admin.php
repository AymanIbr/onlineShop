<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;



Route::prefix('admin/dashboard')->middleware('auth:admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('index');
});
