<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;



class CartModelRepository implements CartRepository
{
    protected $items;

    public function __construct()
    {
        $this->items = collect([]);
    }

    public function get(): Collection
    {
        if (!$this->items->count()) {
            $this->items = Cart::with('product')->where('cookie_id', $this->getCartIdentifier())->get();
        }
        return $this->items;
    }

    public function add(Product $product, $quantity = 1)
    {
        $item = Cart::where('product_id', $product->id)
            ->where('cookie_id', $this->getCartIdentifier())
            ->first();

        if (!$item) {
            $cart = Cart::create([
                'cookie_id' => $this->getCartIdentifier(),
                'user_id' => Auth::guard('web')->id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);

            return $cart->load('product');
        }

        $item->increment('quantity', $quantity);
        return $item->fresh('product');
    }

    public function update($id, $quantity)
    {
        return Cart::where('id', $id)
            ->where('cookie_id', $this->getCartIdentifier())
            ->update([
                'quantity' => $quantity
            ]);
    }

    public function delete($id)
    {
        Cart::where('id', $id)
            ->where('cookie_id', $this->getCartIdentifier())
            ->delete();
    }

    public function empty()
    {
        return Cart::where('cookie_id', $this->getCartIdentifier())->delete();
    }

    public function total(): float
    {
        return $this->get()->sum(function ($item) {
            return  $item->quantity * $item->product->price;
        });
    }

    protected function getCartIdentifier()
    {
        if ($userId = Auth::guard('web')->id()) {
            return 'user_' . $userId;
        }
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_id', $cookie_id, 30 * 24 * 60);
        }
        return 'guest_' . $cookie_id;
    }
}
