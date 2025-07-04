<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->paginate(10);

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = new Category();
        return view('dashboard.categories.create', compact('category'));
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
            'show_home' => 'required|boolean',
            'image' => 'required|image|max:2048|mimes:png,jpg',
        ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'message' => $validator->getMessageBag()->first()
        //     ], 422);
        // }

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $category = Category::create([
            'name' => $request->name,
            'active' => $request->active,
            'show_home' => $request->show_home,
        ]);

        $path =  $request->file('image')->store('uploads', 'custom');
        $category->image()->create([
            'path' => $path
        ]);

        return response()->json([
            'message' => 'Saved Successfully',
        ], 201);
    }

    // public function uploadImage(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|image|max:2048|mimes:jpg,jpeg,png'
    //     ]);

    //     $path = $request->file('file')->store('uploads', 'public');

    //     return response()->json([
    //         'path' => $path
    //     ]);
    // }

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
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:30',
            'active' => 'required|boolean',
            'show_home' => 'required|boolean',
            'image' => 'nullable|image|max:2048|mimes:png,jpg',
        ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'message' => $validator->getMessageBag()->first()
        //     ], 422);
        // }

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $category->update([
            'name' => $request->name,
            'active' => $request->active,
            'show_home' => $request->show_home,
        ]);

        if ($request->hasFile('image')) {
            if ($category->image) {
                File::delete('storage/' . $category->image->path);
                $category->image()->delete();
            }

            $path = $request->file('image')->store('uploads', 'custom');
            $category->image()->create([
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
    public function destroy(Category $category)
    {
        if ($category->image) {
            File::delete('storage/' . $category->image->path);
        }
        $category->image()->delete();
        $isDeleted = $category->delete();
        if ($isDeleted) {
            return response()->json(['title' => 'Success', 'text' => 'Category Deleted Successfully', 'icon' => 'success']);
        } else {
            return response()->json(['title' => 'Failed', 'text' => 'Category Deleted Failed', 'icon' => 'error']);
        }
    }
}
