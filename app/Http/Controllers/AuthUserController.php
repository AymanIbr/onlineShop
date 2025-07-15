<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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


    public function showPassword()
    {
        return view('front.change-password');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => ['required'],
            'new_password' => ['required', 'min:6', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::guard('web')->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'errors' => ['old_password' => ['Your old password is incorrect, please try again.']]
            ], 422);
        }

        if (Hash::check($request->new_password, $user->password)) {
            return response()->json([
                'errors' => ['new_password' => ['New password cannot be the same as the old password']]
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'message' => 'You have successfully changed your password.'
        ]);
    }



    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        if (!User::where('email', $request->email)->exists()) {
            throw ValidationException::withMessages([
                'email' => ['This email address is invalid.'],
            ]);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => trans($status)]);
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}
