<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\Intl\Countries;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = ShippingCharge::latest();

        if ($request->filled('search')) {
            $query->where('country', 'like', '%' . strtoupper($request->search) . '%');
        }
        $shippings = $query->paginate(10);


        return view('dashboard.shipping.index', [
            'countries' => Countries::getNames(),
            'shippings' => $shippings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $shipping = new ShippingCharge();
        $countries = Countries::getNames();
        return view('dashboard.shipping.create', compact('shipping', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country' => 'required|string|size:2|unique:shipping_charges,country',
            'amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        ShippingCharge::create([
            'country' => $request->country,
            'amount' => $request->amount
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
    public function edit(ShippingCharge $shipping)
    {
        $countries = Countries::getNames();
        return view('dashboard.shipping.edit', compact('shipping', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingCharge $shipping)
    {
        $validator = Validator::make($request->all(), [
            'country' => [
                'required',
                'string',
                'size:2',
                Rule::unique('shipping_charges', 'country')->ignore($shipping->id),
            ],
            'amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $shipping->update([
            'country' => $request->country,
            'amount' => $request->amount
        ]);

        return response()->json([
            'message' => 'Saved Successfully',
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingCharge $shipping)
    {
        $isDeleted = $shipping->delete();
        if ($isDeleted) {
            return response()->json(['title' => 'Success', 'text' => 'Shipping Deleted Successfully', 'icon' => 'success']);
        } else {
            return response()->json(['title' => 'Failed', 'text' => 'Shipping Deleted Failed', 'icon' => 'error']);
        }
    }
}
