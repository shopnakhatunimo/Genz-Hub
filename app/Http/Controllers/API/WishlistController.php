<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * উইশলিস্টে টগল করুন (AJAX)
     */
    public function toggle(Request $request): JsonResponse
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $existing = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'success'  => true,
                'in_list'  => false,
                'message'  => 'উইশলিস্ট থেকে সরানো হয়েছে।',
            ]);
        }

        Wishlist::create([
            'user_id'    => Auth::id(),
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'success' => true,
            'in_list' => true,
            'message' => 'উইশলিস্টে যোগ করা হয়েছে।',
        ]);
    }

    /**
     * উইশলিস্টের তালিকা (API)
     */
    public function index(): JsonResponse
    {
        $items = Wishlist::where('user_id', Auth::id())
            ->with('product.images')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $items,
            'count'   => $items->count(),
        ]);
    }
}
