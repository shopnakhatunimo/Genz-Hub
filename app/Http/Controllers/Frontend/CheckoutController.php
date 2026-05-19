<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('warning', 'চেকআউট করতে প্রথমে লগইন করুন।');
        }

        $cart = Cart::where('user_id', auth()->id())->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')->with('warning', 'আপনার কার্ট খালি।');
        }

        $addresses = Address::where('user_id', auth()->id())->get();
        $defaultAddress = Address::where('user_id', auth()->id())->where('is_default', true)->first();

        return view('frontend.checkout.index', compact('cart', 'addresses', 'defaultAddress'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('warning', 'চেকআউট করতে প্রথমে লগইন করুন।');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'area' => 'required|string|max:100',
            'payment_method' => 'required|in:cod,online',
            'notes' => 'nullable|string',
        ]);

        $cart = Cart::where('user_id', auth()->id())->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')->with('warning', 'আপনার কার্ট খালি।');
        }

        try {
            DB::beginTransaction();

            $shippingAddress = implode(', ', [
                $request->address,
                $request->area,
                $request->city,
            ]);

            $order = Order::create([
                'user_id' => auth()->id(),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'shipping_address' => $shippingAddress,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'online' ? 'pending' : 'pending',
                'order_status' => 'pending',
                'subtotal' => $cart->subtotal,
                'shipping_cost' => 60,
                'discount' => $cart->discount,
                'total' => $cart->total + 60,
                'coupon_code' => $cart->coupon_code,
                'notes' => $request->notes,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_image' => $item->product->primaryImage->image ?? null,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                    'variant' => $item->variant,
                ]);

                $item->product->decrement('stock', $item->quantity);
                $item->product->increment('sold_count', $item->quantity);
            }

            if ($cart->coupon) {
                $cart->coupon->incrementUsedCount();
            }

            $cart->items()->delete();
            $cart->update([
                'coupon_code' => null,
                'discount' => 0,
                'subtotal' => 0,
                'total' => 0,
            ]);

            DB::commit();

            return redirect()->route('order.show', $order->order_number)->with('success', 'অর্ডার সফলভাবে সম্পন্ন হয়েছে।');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'অর্ডার করতে সমস্যা হয়েছে। আবার চেষ্টা করুন।');
        }
    }
}
