<?php

use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return view('front.wishlist');
});



Route::name('site.')->controller(FrontController::class)->group(function () {

    Route::get('/', 'index')->name('index');
    Route::get('/shop/{categorySlug?}/{subCategorySlug?}', 'shop')->name('shop');
    Route::get('/product/{product:slug}', 'product')->name('product');
    Route::resource('/carts', CartController::class);
});


Route::middleware('auth:web')->group(function () {

    Route::get('profile', [AuthUserController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthUserController::class, 'updateProfile'])->name('profile.update');


    Route::get('my-order', [AuthUserController::class, 'myOrder'])->name('my.order');
    Route::get('/my-orders/{order}', [AuthUserController::class, 'show'])->name('order.details');

    Route::get('thanks/{order}', [CheckoutController::class, 'thanks'])->name('thanks');

    Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout');
    Route::post('checkout', [CheckoutController::class, 'store']);

    Route::resource('/wishlist', WishlistController::class)->names('site.wishlist');
});
Route::post('/shipping-charge', [CheckoutController::class, 'getCharge'])->name('shipping.charge');
Route::post('/apply-discount', [CheckoutController::class, 'applyDiscount'])->name('apply.discount');
Route::post('/remove-discount', [CheckoutController::class, 'removeDiscount'])->name('remove.discount');
