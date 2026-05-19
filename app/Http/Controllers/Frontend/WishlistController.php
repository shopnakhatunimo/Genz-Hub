<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

/**
 * Dedicated Wishlist Controller
 * Standalone wishlist page এর জন্য।
 */
class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wishlists = Wishlist::where('user_id', auth()->id())
            ->with('product.images')
            ->latest()
            ->get();

        return view('frontend.wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $existing = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'success' => true,
                'in_list' => false,
                'message' => 'উইশলিস্ট থেকে সরানো হয়েছে।',
            ]);
        }

        Wishlist::create([
            'user_id'    => auth()->id(),
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'success' => true,
            'in_list' => true,
            'message' => 'উইশলিস্টে যোগ করা হয়েছে।',
        ]);
    }
}
