<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });



Route::name('site.')->controller(FrontController::class)->group(function () {

    Route::get('/', 'index')->name('index');
    Route::get('/shop/{categorySlug?}/{subCategorySlug?}', 'shop')->name('shop');
    Route::get('/product/{product:slug}', 'product')->name('product');
    Route::resource('/carts', CartController::class);
});


Route::middleware('auth:web')->group(function () {
    Route::view('profile', 'front.profile');
    Route::get('thanks/{order}', [CheckoutController::class, 'thanks'])->name('thanks');

    Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout');
    Route::post('checkout', [CheckoutController::class, 'store']);
});
Route::post('/shipping-charge', [CheckoutController::class, 'getCharge'])->name('shipping.charge');
