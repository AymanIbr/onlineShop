<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthUserController extends Controller
{
    public function profile()
    {
        return view('front.profile');
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
