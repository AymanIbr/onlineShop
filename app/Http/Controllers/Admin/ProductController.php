<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->when(
                $request->filled('search'),
                fn($q) =>
                $q->where('title', 'like', '%' . $request->search . '%')
            )
            ->when(
                $request->filled('category_id'),
                fn($q) =>
                $q->where('category_id', $request->category_id)
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::pluck('name', 'id');

        return view('dashboard.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = new Product();
        $categories = Category::select('id', 'name')->get();
        $brands = Brand::select('id', 'name')->get();
        $subCategory = SubCategory::select('id', 'name')->get();

        return view('dashboard.products.create', compact('product', 'categories', 'brands', 'subCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->merge([
            'active' => $request->has('active'),
            'track_qty' => $request->has('track_qty'),
        ]);
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3|max:100|unique:products,title',
            'description'      => 'nullable|string|max:1000',
            'shipping_returns'      => 'nullable|string|max:1000',
            'price'            => 'required|numeric|min:0',
            'compare_price'    => 'nullable|numeric|min:0|gte:price',
            'quantity'         => 'required|integer|min:0',
            'category_id'      => 'required|exists:categories,id',
            'sub_category_id'  => 'nullable|exists:sub_categories,id',
            'brand_id'         => 'nullable|exists:brands,id',
            'sku'              => 'required|string|max:100|unique:products,sku',
            'barcode'          => 'nullable|string|max:100|unique:products,barcode',
            'active'           => 'nullable|boolean',
            'is_featured'      => 'nullable|boolean',
            'track_qty'        => 'nullable|boolean',
            'image'            => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery.*'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::create([
            'title'            => $request->title,
            'description'      => $request->description,
            'shipping_returns'      => $request->shipping_returns,
            'price'            => $request->price,
            'compare_price'    => $request->compare_price,
            'quantity'         => $request->quantity,
            'category_id'      => $request->category_id,
            'sub_category_id'  => $request->sub_category_id,
            'brand_id'         => $request->brand_id,
            'sku'              => $request->sku,
            'barcode'          => $request->barcode,
            'is_featured'      => $request->input('is_featured', 0),
            'active'           => $request->boolean('active'),
            'track_qty'        => $request->boolean('track_qty'),
        ]);

        $path = $request->file('image')->store('uploads', 'custom');
        $product->image()->create([
            'path' => $path,
        ]);


        if ($request->has('gallery') && is_array($request->gallery)) {
            foreach ($request->gallery as $img) {
                $path = $img->store('uploads', 'custom');
                $product->gallery()->create([
                    'path' => $path,
                    'type' => 'gallery'
                ]);
            }
        }

        return response()->json([
            'message' => 'Saved Successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

        // if (empty($product)) {
        //     flash()->error('Product not found!');
        //     return redirect()->route('admin.products.index');
        // }
        $categories = Category::select('id', 'name')->get();
        $brands = Brand::select('id', 'name')->get();
        $subCategory = SubCategory::select('id', 'name')->get();
        return view('dashboard.products.edit', compact('product', 'categories', 'brands', 'subCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        $request->merge([
            'active' => $request->has('active'),
            'track_qty' => $request->has('track_qty'),
        ]);
        $validator = Validator::make($request->all(), [
            'title'            => 'required|string|min:3|max:100',
            'description'      => 'nullable|string|max:1000',
            'shipping_returns'      => 'nullable|string|max:1000',
            'price'            => 'required|numeric|min:0',
            'compare_price'    => 'nullable|numeric|min:0|gte:price',
            'quantity'         => 'required|integer|min:0',
            'category_id'      => 'required|exists:categories,id',
            'sub_category_id'  => 'nullable|exists:sub_categories,id',
            'brand_id'         => 'nullable|exists:brands,id',
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
            'barcode' => 'nullable|string|max:100|unique:products,barcode,' . $product->id,
            'active'           => 'nullable|boolean',
            'is_featured'      => 'nullable|boolean',
            'track_qty'        => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery.*'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $product->update([
            'title'            => $request->title,
            'description'      => $request->description,
            'shipping_returns'      => $request->shipping_returns,
            'price'            => $request->price,
            'compare_price'    => $request->compare_price,
            'quantity'         => $request->quantity,
            'category_id'      => $request->category_id,
            'sub_category_id'  => $request->sub_category_id,
            'brand_id'         => $request->brand_id,
            'sku'              => $request->sku,
            'barcode'          => $request->barcode,
            'is_featured'      => $request->input('is_featured', 0),
            'active'           => $request->boolean('active'),
            'track_qty'        => $request->boolean('track_qty'),
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                File::delete('storage/' . $product->image->path);
                $product->image()->delete();
            }

            $path = $request->file('image')->store('uploads', 'custom');
            $product->image()->create([
                'path' => $path,
            ]);
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $path = $img->store('uploads', 'custom');
                $product->gallery()->create([
                    'path' => $path,
                    'type' => 'gallery'
                ]);
            }
        }

        return response()->json([
            'message' => 'Saved Successfully',
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            File::delete('storage/' . $product->image->path);
        }
        foreach ($product->gallery as $img) {
            File::delete('storage/' . $img->path);
        }
        $product->image()->delete();
        $product->gallery()->delete();
        $isDeleted = $product->delete();

        if ($isDeleted) {
            return response()->json(['title' => 'Success', 'text' => 'Product Deleted Successfully', 'icon' => 'success']);
        } else {
            return response()->json(['title' => 'Failed', 'text' => 'Product Deleted Failed', 'icon' => 'error']);
        }
    }

    function delete_img($id)
    {
        $img = Image::find($id);
        File::delete('storage/' . $img->path);
        return Image::destroy($id);
    }

    public function getSubCategories($category_id)
    {
        $subCategories = SubCategory::where('category_id', $category_id)
            ->where('active', 1)
            ->select('id', 'name')
            ->get();
        return response()->json($subCategories);
    }
}
