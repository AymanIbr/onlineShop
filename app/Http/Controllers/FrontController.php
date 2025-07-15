<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\Rating;
use App\Models\SubCategory;
use App\Repositories\Wishlist\WishlistRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    public function index(WishlistRepository $wishlistRepo)
    {
        $products = Product::where('is_featured', true)
            ->where('active', true)
            ->get();

        $latestProduct = Product::where('active', true)
            ->orderBy('id', 'DESC')
            ->take(8)
            ->get();

        $wishlistItems = $wishlistRepo->get()->pluck('product_id')->toArray();


        return view('front.index', compact('products', 'latestProduct', 'wishlistItems'));
    }

    public function shop(Request $request, WishlistRepository $wishlistRepo, $categorySlug = null, $subCategorySlug = null)
    {
        $categories = Category::select('id', 'name', 'slug')
            ->with(['sub_categories' => function ($query) {
                $query->where('active', true);
            }])
            ->where('active', true)
            ->get();

        $brands = Brand::select('id', 'name')
            ->where('active', true)->get();

        $query = Product::with('category', 'subCategory')
            ->where('active', true);

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->firstOrFail();
            $query->where('category_id', $category->id);

            if ($subCategorySlug) {

                $subCategory = SubCategory::where('slug', $subCategorySlug)
                    ->where('category_id', $category->id)
                    ->firstOrFail();

                $query->where('sub_category_id', $subCategory->id);
            }
        }


        // brand

        $brandNames = request()->query('brands');
        $brandArray = $brandNames ? explode(',', $brandNames) : [];
        if (!empty($brandArray)) {
            $query->whereHas('brand', function ($q) use ($brandArray) {
                $q->whereIn('name', $brandArray);
            });
        }

        // price
        if ($request->get('price_max') != '' && $request->get('price_min') != '') {
            $query->whereBetween('price', [
                intval($request->get('price_min')),
                intval($request->get('price_max')),
            ]);
        }

        // Sorting
        if ($request->get('sort')) {
            switch ($request->get('sort')) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'latest':
                default:
                    $query->orderBy('id', 'desc');
                    break;
            }
        }

        // search

        if (!empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $wishlistItems = $wishlistRepo->get()->pluck('product_id')->toArray();


        $priceMax = intval($request->get('price_max') == 0) ? 1000 : $request->get('price_max');
        $priceMin = intval($request->get('price_min'));
        $products = $query->paginate(3);

        return view('front.shop', compact('categories', 'brands', 'products', 'categorySlug', 'subCategorySlug', 'priceMax', 'priceMin', 'wishlistItems'));
    }



    public function product(Product $product)
    {

        $product->loadCount('ratings')
            ->loadSum('ratings', 'rating')
            ->load(['image', 'gallery', 'ratings']);


        // Rating Calculation
        $avgRating = $product->ratings_count > 0
            ? number_format(($product->ratings_sum_rating  / $product->ratings_count), 2)
            : 0;

        $avgRatingPer = ($avgRating * 100) / 5;

        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where('active', true)
            ->where(function ($query) use ($product) {
                $query->where('category_id', $product->category_id)
                    ->orWhere('sub_category_id', $product->sub_category_id)
                    ->orWhere('brand_id', $product->brand_id);
            })
            ->with(['image'])
            ->latest()
            ->take(9)
            ->get();

        return view('front.product', compact('product', 'relatedProducts', 'avgRating', 'avgRatingPer'));
    }

    public function page(Page $page)
    {
        return view('front.page', compact('page'));
    }


    public function saveRating(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|email',
            'rating' => 'required|in:1,2,3,4,5',
            'comment' => 'required|string',
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 422);
        }

        $count = Rating::where('email', $request->email)
            ->where('product_id', $request->product_id)
            ->count();

        if ($count > 0) {
            return response()->json(['message' => 'You have already rated this product'], 422);
        }

        $rating = Rating::create([
            'product_id' => $request->product_id,
            'username' => $request->username,
            'email' => $request->email,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 0,
        ]);
        $product = Product::with('ratings')->withCount('ratings')->withSum('ratings', 'rating')->find($request->product_id);

        $averageRating = 0;
        if ($product->ratings_count > 0) {
            $averageRating = round($product->ratings_sum_rating / $product->ratings_count, 1);
        }

        return response()->json([
            'message' => 'Your review has been submitted successfully. Thank you for your feedback!',
            'rating' => $rating,
            'ratings_count' => $product->ratings_count,
            'ratings_rating' => $averageRating,
        ], 200);
    }
}
