<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Wishlist\WishlistModelRepository;
use App\Repositories\Wishlist\WishlistRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Binding Cart Repository
        $this->app->bind(CartRepository::class, function () {
            return new CartModelRepository();
        });

        // Binding Wishlist Repository
        $this->app->bind(WishlistRepository::class, function () {
            return new WishlistModelRepository();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();
    }
}
