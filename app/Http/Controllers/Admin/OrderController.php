<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function (Builder $q) use ($search) {
                $q->where('number', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%")
                    ->orWhere('payment_status', 'like', "%$search%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%");
                    });
            });
        }

        $orders = $query->latest()->paginate(10);

        return view('dashboard.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'addresses']);
        return view('dashboard.orders.show', compact('order'));
    }


    public function edit(Order $order)
    {
        return view('dashboard.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,delivering,completed,cancelled,refunded',
            'payment_status' => 'required|in:pending,paid,failed',
            'payment_method' => 'required|in:cod,stripe'
        ]);

        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'payment_method' => $request->payment_method
        ]);

        return response()->json([
            'message' => 'Order updated successfully',
        ]);
    }



    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->addresses()->delete();

        $isDeleted = $order->delete();

        if ($isDeleted) {
            return response()->json(['title' => 'Success', 'text' => 'Order Deleted Successfully', 'icon' => 'success']);
        } else {
            return response()->json(['title' => 'Failed', 'text' => 'Order Deletion Failed', 'icon' => 'error']);
        }
    }
}
