<?php

namespace App\Repositories\Wishlist;


use App\Models\Product;
use Illuminate\Support\Collection;

interface WishlistRepository
{
    public function get(): Collection;
    public function add(Product $product);
    public function remove($productId);
    public function exists($productId): bool;
}
