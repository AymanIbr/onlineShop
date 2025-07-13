<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Page::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        $pages = $query->latest()->paginate(10);

        return view('dashboard.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = new Page();
        return view('dashboard.pages.create', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'active' => $request->boolean('active'),
        ]);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:30',
            'active' => 'required|boolean',
            'content' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        Page::create([
            'name' => $request->name,
            'active' => $request->active,
            'content' => $request->content,
        ]);

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
    public function edit(Page $page)
    {
        return view('dashboard.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $request->merge([
            'active' => $request->boolean('active'),
        ]);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:30',
            'active' => 'required|boolean',
            'content' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $page->update([
            'name' => $request->name,
            'active' => $request->active,
            'content' => $request->content,
        ]);

        return response()->json([
            'message' => 'Update Successfully',
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
         $isDeleted = $page->delete();
        if ($isDeleted) {
            return response()->json(['title' => 'Success', 'text' => 'Page Deleted Successfully', 'icon' => 'success']);
        } else {
            return response()->json(['title' => 'Failed', 'text' => 'Page Deleted Failed', 'icon' => 'error']);
        }
    }
}
