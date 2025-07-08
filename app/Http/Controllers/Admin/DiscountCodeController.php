<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DiscountCoupon::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        $coupons = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('dashboard.coupon.index', compact('coupons'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $coupon = new DiscountCoupon();
        return view('dashboard.coupon.create', compact('coupon'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'active' => $request->has('active'),
        ]);
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:discount_coupons,code|max:255',
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'max_uses' => 'nullable|integer|min:1',
            'max_uses_user' => 'nullable|integer|min:1',
            'type' => 'required|in:percent,fixed',
            'discount_amount' => 'required|numeric|min:0',
            'min_amount' => 'nullable|numeric|min:0',
            'active' => 'nullable|boolean',
            'starts_at' => 'required|date',
            'expires_at' => 'required|date|after_or_equal:starts_at',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        DiscountCoupon::create($data);

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
    public function edit(DiscountCoupon $coupon)
    {
        return view('dashboard.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DiscountCoupon $coupon)
    {
        $request->merge([
            'active' => $request->has('active'),
        ]);
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255|unique:discount_coupons,code,' . $coupon->id,
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'max_uses' => 'nullable|integer|min:1',
            'max_uses_user' => 'nullable|integer|min:1',
            'type' => 'required|in:percent,fixed',
            'discount_amount' => 'required|numeric|min:0',
            'min_amount' => 'nullable|numeric|min:0',
            'active' => 'nullable|boolean',
            'starts_at' => 'required|date',
            'expires_at' => 'required|date|after_or_equal:starts_at',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $coupon->update([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'max_uses' => $request->max_uses,
            'max_uses_user' => $request->max_uses_user,
            'type' => $request->type,
            'discount_amount' => $request->discount_amount,
            'min_amount' => $request->min_amount,
            'active' => $request->has('active') ? (bool)$request->active : false,
            'starts_at' => $request->starts_at,
            'expires_at' => $request->expires_at,
        ]);

        return response()->json([
            'message' => 'Coupon updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DiscountCoupon $coupon)
    {
        $isDeleted = $coupon->delete();
        if ($isDeleted) {
            return response()->json(['title' => 'Success', 'text' => 'Coupon Deleted Successfully', 'icon' => 'success']);
        } else {
            return response()->json(['title' => 'Failed', 'text' => 'Coupon Deleted Failed', 'icon' => 'error']);
        }
    }
}
