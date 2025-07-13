<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        $users = $query->latest()->paginate(10);

        return view('dashboard.users.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User();
        return view('dashboard.users.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|min:3|max:30',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:255',
            'active'   => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'password' => bcrypt('password'),
            'active'   => $request->active,
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
    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, User $user)
    {
        $request->merge([
            'active' => $request->boolean('active'),
        ]);
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|min:3|max:30',
            'email'    => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:255',
            'active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $user->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
            'active'  => $request->active,
        ]);

        return response()->json([
            'message' => 'Updated Successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $isDeleted = $user->delete();
        if ($isDeleted) {
            return response()->json(['title' => 'Success', 'text' => 'User Deleted Successfully', 'icon' => 'success']);
        } else {
            return response()->json(['title' => 'Failed', 'text' => 'User Deleted Failed', 'icon' => 'error']);
        }
    }
}
