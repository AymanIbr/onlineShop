<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthUserController extends Controller
{
    public function profile()
    {

        $user = Auth::guard('web')->user();
        return view('front.profile', compact('user'));
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('web')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:1000',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Profile updated successfully',
            ]);
        }
    }

    public function myOrder()
    {
        $user = Auth::guard('web')->user();
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', "DESC")->get();
        return view('front.my-orders', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'You are not allowed to view this order.');
        }

        $order->load(['items.product', 'addresses']);

        return view('front.order-detail', compact('order'));
    }
}
