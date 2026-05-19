<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * কার্টের সংখ্যা ও সারসংক্ষেপ (API)
     */
    public function summary(): JsonResponse
    {
        $cart  = Cart::where('user_id', Auth::id())->with('items.product')->first();
        $count = $cart ? $cart->items->sum('quantity') : 0;
        $total = $cart ? $cart->items->sum('subtotal') : 0;

        return response()->json([
            'success' => true,
            'count'   => $count,
            'total'   => $total,
        ]);
    }

    /**
     * কার্টে পণ্য যোগ করুন (AJAX)
     */
    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < 1) {
            return response()->json(['success' => false, 'message' => 'পণ্যটি স্টকে নেই।'], 422);
        }

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        $qty = $request->get('quantity', 1);

        if ($item) {
            $item->increment('quantity', $qty);
            $item->update(['subtotal' => $item->price * $item->quantity]);
        } else {
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $product->id,
                'quantity'   => $qty,
                'price'      => $product->sale_price ?? $product->price,
                'subtotal'   => ($product->sale_price ?? $product->price) * $qty,
            ]);
        }

        $count = CartItem::where('cart_id', $cart->id)->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'পণ্যটি কার্টে যোগ করা হয়েছে।',
            'count'   => $count,
        ]);
    }

    /**
     * কার্ট থেকে পণ্য সরান (AJAX)
     */
    public function remove(Request $request): JsonResponse
    {
        $request->validate(['item_id' => 'required|exists:cart_items,id']);

        $item = CartItem::where('id', $request->item_id)
            ->whereHas('cart', fn($q) => $q->where('user_id', Auth::id()))
            ->firstOrFail();

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'পণ্যটি কার্ট থেকে সরানো হয়েছে।',
        ]);
    }
}
