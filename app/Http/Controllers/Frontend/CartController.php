<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getCart();
        return view('frontend.cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variant' => 'nullable|array',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->isInStock()) {
            return response()->json([
                'success' => false,
                'message' => 'পণ্যটি স্টকে নেই।'
            ]);
        }

        if ($request->quantity > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'পর্যাপ্ত স্টক নেই।'
            ]);
        }

        $cart = $this->getCart();

        $cartItem = $cart->items()->where('product_id', $request->product_id)->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($newQuantity > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'পর্যাপ্ত স্টক নেই।'
                ]);
            }
            $cartItem->update([
                'quantity' => $newQuantity,
                'price' => $product->final_price,
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $product->final_price,
                'variant' => $request->variant,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'পণ্যটি কার্টে যোগ করা হয়েছে।',
            'cart_count' => $cart->getItemCount(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($request->item_id);
        $product = $cartItem->product;

        if ($request->quantity > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'পর্যাপ্ত স্টক নেই।'
            ]);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json([
            'success' => true,
            'message' => 'কার্ট আপডেট করা হয়েছে।',
            'subtotal' => number_format($cartItem->subtotal, 2),
            'total' => number_format($cartItem->cart->total, 2),
        ]);
    }

    public function remove(Request $request)
    {
        $cartItem = CartItem::findOrFail($request->item_id);
        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'পণ্যটি কার্ট থেকে সরানো হয়েছে।',
            'cart_count' => $cartItem->cart->getItemCount(),
            'total' => number_format($cartItem->cart->total, 2),
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $cart = $this->getCart();
        $coupon = \App\Models\Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'অবৈধ বা মেয়াদোত্তীর্ণ কুপন কোড।'
            ]);
        }

        if ($cart->subtotal < $coupon->min_order_amount) {
            return response()->json([
                'success' => false,
                'message' => "মিনিমাম অর্ডার পরিমাণ {$coupon->min_order_amount} টাকা হতে হবে।"
            ]);
        }

        $cart->update(['coupon_code' => $request->coupon_code]);
        $cart->updateTotals();

        return response()->json([
            'success' => true,
            'message' => 'কুপন সফলভাবে প্রয়োগ করা হয়েছে।',
            'discount' => number_format($cart->discount, 2),
            'total' => number_format($cart->total, 2),
        ]);
    }

    private function getCart()
    {
        if (auth()->check()) {
            $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        } else {
            $sessionId = session()->getId();
            $cart = Cart::firstOrCreate(['session_id' => $sessionId]);
        }
        return $cart;
    }
}
