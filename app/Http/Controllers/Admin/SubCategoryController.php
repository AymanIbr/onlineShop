<?php

namespace App\Http\Controllers\Admin;

use App\Models\SubCategory;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SubCategory::with('category')->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $subCategory = $query->paginate(10);

        return view('dashboard.sub-categories.index', compact('subCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        $subCategory = new SubCategory();
        return view('dashboard.sub-categories.create', compact('subCategory', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:30',
            'active' => 'required|boolean',
            'category_id' => 'required|integer|exists:categories,id',
            'image' => 'required|image|max:2048|mimes:png,jpg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $subCategory = SubCategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'active' => $request->active,
        ]);

        $path =  $request->file('image')->store('uploads', 'custom');
        $subCategory->image()->create([
            'path' => $path
        ]);

        return response()->json([
            'message' => 'Saved Successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subCategory)
    {
        $categories = Category::select('id', 'name')->get();
        return view('dashboard.sub-categories.edit', compact('subCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:30',
            'active' => 'required|boolean',
            'category_id' => 'required|integer|exists:categories,id',
            'image' => 'nullable|image|max:2048|mimes:png,jpg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $subCategory->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'active' => $request->active,
        ]);

        if ($request->hasFile('image')) {
            if ($subCategory->image) {
                File::delete('storage/' . $subCategory->image->path);
                $subCategory->image()->delete();
            }

            $path = $request->file('image')->store('uploads', 'custom');
            $subCategory->image()->create([
                'path' => $path,
            ]);
        }

        return response()->json([
            'message' => 'Updated Successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subCategory)
    {
        if ($subCategory->image) {
            File::delete('storage/' . $subCategory->image->path);
        }
        $subCategory->image()->delete();
        $isDeleted = $subCategory->delete();
        if ($isDeleted) {
            return response()->json(['title' => 'Success', 'text' => 'Sub Category Deleted Successfully', 'icon' => 'success']);
        } else {
            return response()->json(['title' => 'Failed', 'text' => 'Sub Category Deleted Failed', 'icon' => 'error']);
        }
    }
}
