<?php


namespace App\Repositories\Wishlist;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Repositories\Wishlist\WishlistRepository;


class WishlistModelRepository implements WishlistRepository
{
    protected $items;

    public function __construct()
    {
        $this->items = collect([]);
    }

    public function get(): Collection
    {
        if (!$this->items->count()) {
            $this->items = Wishlist::with('product')
                ->where('cookie_id', $this->getIdentifier())
                ->get();
        }

        return $this->items;
    }

    public function add(Product $product)
    {
        return Wishlist::firstOrCreate([
            'cookie_id' => $this->getIdentifier(),
            'user_id' => Auth::guard('web')->id(),
            'product_id' => $product->id,
        ]);
    }

    public function remove($productId)
    {
        return Wishlist::where('cookie_id', $this->getIdentifier())
            ->where('product_id', $productId)
            ->delete();
    }

    public function exists($productId): bool
    {
        return Wishlist::where('cookie_id', $this->getIdentifier())
            ->where('product_id', $productId)
            ->exists();
    }

    protected function getIdentifier()
    {
        if ($userId = Auth::guard('web')->id()) {
            return 'user_' . $userId;
        }

        $cookie_id = Cookie::get('wishlist_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('wishlist_id', $cookie_id, 30 * 24 * 60);
        }

        return 'guest_' . $cookie_id;
    }
}
