<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart)
    {
        if ($cart->get()->count() == 0) {
            session()->flash('swal', [
                'title' => 'Warning',
                'text' => 'No items in cart!',
                'icon' => 'warning',
                'showCancelButton' => false,
                'confirmButtonText' => 'OK',
            ]);
            return redirect()->route('site.index');
        }

        return view('front.checkout', [
            'cart' => $cart,
            'countries' => Countries::getNames(),
        ]);
    }


    public function store(Request $request, CartRepository $cart)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'country' => ['required', 'string', 'size:2'],
            'payment_method' => ['required', 'in:cod,stripe'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {

            foreach ($cart->get() as $item) {
                $product = Product::find($item->product_id);
                if (!$product || $product->quantity < $item->quantity) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => "For product unavailable quantity:  {$product->title}"
                    ], 400);
                }
            }

            $paymentMethod = $request->payment_method;
            $order = Order::create([
                'user_id' => Auth::id(),
                'shipping' => 20,
                'discount' => $request->input('discount', 0),
                'total' => $cart->total() + 20 - $request->input('discount', 0),
                'coupon_code' => $request->input('coupon_code'),
                'payment_method' => $paymentMethod,
                'status' => 'pending',
                'payment_status' => $paymentMethod === 'cod' ? 'pending' : 'paid',
            ]);

            if ($paymentMethod === 'stripe') {
            }



            foreach ($cart->get() as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->title,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                ]);
            }
            $order->addresses()->create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'appartment' => $request->appartment,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'country' => $request->country,
                'order_notes' => $request->order_notes,
            ]);

            foreach ($cart->get() as $item) {
                Product::where('id', $item->product_id)
                    ->update([
                        'quantity' => DB::raw("quantity - {$item->quantity}")
                    ]);
            }

            $cart->empty();
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Order placed successfully!',
                'redirect' => route('thanks', ['order' => $order->id])
            ]);
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }


    public function thanks($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('front.thanks', compact('order'));
    }
}
