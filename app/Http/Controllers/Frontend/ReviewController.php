<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $order = Order::where('id', $request->order_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'অর্ডার পাওয়া যায়নি।');
        }

        $exists = Review::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'আপনি ইতিমধ্যেই এই পণ্যের রিভিউ দিয়েছেন।');
        }

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . rand(1, 1000) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/reviews'), $imageName);
                $images[] = $imageName;
            }
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'images' => $images,
            'is_verified' => $order->order_status === 'delivered',
        ]);

        return redirect()->back()->with('success', 'রিভিউ সফলভাবে জমা দেওয়া হয়েছে।');
    }
}
