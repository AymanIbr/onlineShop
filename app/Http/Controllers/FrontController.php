<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $products = Product::where('is_featured', true)
            ->where('active', true)
            ->get();

        $latestProduct = Product::where('active', true)
            ->orderBy('id', 'DESC')
            ->take(8)
            ->get();

        return view('front.index', compact('products', 'latestProduct'));
    }

    public function shop(Request $request, $categorySlug = null, $subCategorySlug = null)
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

        $priceMax = intval($request->get('price_max') == 0) ? 1000 : $request->get('price_max');
        $priceMin = intval($request->get('price_min'));
        $products = $query->paginate(3);

        return view('front.shop', compact('categories', 'brands', 'products', 'categorySlug', 'subCategorySlug', 'priceMax', 'priceMin'));
    }



    public function product(Product $product)
    {

        $product->load(['image', 'gallery']);

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

        return view('front.product', compact('product', 'relatedProducts'));
    }
}
