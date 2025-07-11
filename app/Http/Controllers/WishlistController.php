<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Wishlist\WishlistRepository;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    protected $wishlist;

    public function __construct(WishlistRepository $wishlist)
    {
        $this->wishlist = $wishlist;
    }

    public function index()
    {
        $wishlistItems = $this->wishlist->get();

        return view('front.wishlist', [
            'wishlist' => $wishlistItems,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id']
        ]);

        $product = Product::findOrFail($request->post('product_id'));
        $this->wishlist->add($product);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Product added to wishlist.'], 201);
        }

        return redirect()->back()->with('success', 'Product added to wishlist.');
    }

    public function destroy($productId)
    {
        $this->wishlist->remove($productId);
        if (request()->expectsJson()) {
            return response()->json(['message' => 'Product removed from wishlist.']);
        }
        return redirect()->back()->with('success', 'Product removed from wishlist.');
    }
}
