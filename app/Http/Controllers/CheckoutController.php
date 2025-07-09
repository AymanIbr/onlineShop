<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DiscountCoupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShippingCharge;
use App\Repositories\Cart\CartRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller
{
    public function create(Request $request, CartRepository $cart)
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
            'totalShippingCharge' => 0,
            'appliedCoupon' => session('coupon'),
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

            $subtotal = $cart->total();

            // Apply Discount Here
            $coupon = session('coupon');
            $discount = 0;
            if ($coupon) {
                if ($coupon['type'] == 'percent') {
                    $discount = ($coupon['amount'] / 100) * $subtotal;
                } else {
                    $discount = $coupon['amount'];
                }
            }

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

            // calculate shipping
            $shippingCharge = ShippingCharge::where('country', $request->country)->value('amount') ?? 0;

            $order = Order::create([
                'user_id' => Auth::id(),
                'shipping' => $shippingCharge,
                'discount' => $discount,
                'coupon_code' => $coupon['code'] ?? null,
                'total' => $subtotal + $shippingCharge - $discount,
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

    public function getCharge(Request $request)
    {
        $country = $request->input('country');
        $amount = ShippingCharge::where('country', $country)->value('amount') ?? 0;

        return response()->json([
            'amount' => $amount,
        ]);
    }

    public function applyDiscount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $code = DiscountCoupon::where('code', $request->code)->first();

        if (!$code || !$code->active) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or inactive discount coupon.',
            ], 404);
        }

        $now = Carbon::now();

        if ($code->starts_at && $now->lt(Carbon::parse($code->starts_at))) {
            return response()->json([
                'status' => false,
                'message' => 'This coupon is not yet active.',
            ], 400);
        }

        if ($code->expires_at && $now->gt(Carbon::parse($code->expires_at))) {
            return response()->json([
                'status' => false,
                'message' => 'This coupon has expired.',
            ], 400);
        }

        $totalUses = Order::where('coupon_code', $code->code)->count();
        if ($code->max_uses !== null && $totalUses >= $code->max_uses) {
            return response()->json([
                'status' => false,
                'message' => 'This coupon has reached its maximum usage limit.',
            ], 400);
        }

        if (Auth::check() && $code->max_uses_user !== null) {
            $userUses = Order::where('coupon_code', $code->code)
                ->where('user_id', Auth::id())
                ->count();

            if ($userUses >= $code->max_uses_user) {
                return response()->json([
                    'status' => false,
                    'message' => 'You have reached the maximum usage limit for this coupon.',
                ], 400);
            }
        }

        session()->put('coupon', [
            'code' => $code->code,
            'type' => $code->type,
            'amount' => $code->discount_amount,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Coupon applied successfully!',
            'type' => $code->type,
            'amount' => $code->discount_amount,
        ]);
    }

    public function removeDiscount(Request $request)
    {
        if (session()->has('discount_coupon')) {
            session()->forget('discount_coupon');
        }
        return response()->json(['status' => true, 'message' => 'Coupon removed successfully']);
    }
}
