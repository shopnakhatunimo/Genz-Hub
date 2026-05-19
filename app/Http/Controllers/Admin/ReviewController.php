<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $query = Review::with(['user', 'product']);

        if ($request->status) {
            $query->where('is_approved', $request->status === 'approved');
        }

        if ($request->search) {
            $query->where('comment', 'like', '%' . $request->search . '%');
        }

        $reviews = $query->latest()->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => true]);

        return redirect()->back()->with('success', 'রিভিউ অনুমোদন করা হয়েছে।');
    }

    public function reject($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => false]);

        return redirect()->back()->with('success', 'রিভিউ প্রত্যাখ্যান করা হয়েছে।');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'রিভিউ মুছে ফেলা হয়েছে।');
    }
}
