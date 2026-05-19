<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('status', true)->with('primaryImage', 'category');

        // Category filter
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        // Subcategory filter
        if ($request->subcategory) {
            $query->where('subcategory_id', $request->subcategory);
        }

        // Price range filter
        if ($request->min_price) {
            $query->where(function ($q) use ($request) {
                $q->whereRaw('COALESCE(discount_price, price) >= ?', [$request->min_price]);
            });
        }
        if ($request->max_price) {
            $query->where(function ($q) use ($request) {
                $q->whereRaw('COALESCE(discount_price, price) <= ?', [$request->max_price]);
            });
        }

        // Search
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sorting
        switch ($request->sort) {
            case 'price_low':
                $query->orderByRaw('COALESCE(discount_price, price) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(discount_price, price) DESC');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $query->orderBy('sold_count', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(20);
        $categories = Category::where('status', true)->get();

        return view('frontend.shop.index', compact('products', 'categories'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->where('status', true)->firstOrFail();
        $products = Product::where('category_id', $category->id)
            ->where('status', true)
            ->with('primaryImage')
            ->paginate(20);

        return view('frontend.shop.category', compact('category', 'products'));
    }

    public function subcategory($slug)
    {
        $subcategory = Subcategory::where('slug', $slug)->where('status', true)->firstOrFail();
        $products = Product::where('subcategory_id', $subcategory->id)
            ->where('status', true)
            ->with('primaryImage')
            ->paginate(20);

        return view('frontend.shop.subcategory', compact('subcategory', 'products'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->where('status', true)
            ->with(['images', 'category', 'subcategory', 'reviews' => function ($q) {
                $q->where('is_approved', true)->latest();
            }])
            ->firstOrFail();

        $product->incrementViewCount();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', true)
            ->with('primaryImage')
            ->take(8)
            ->get();

        return view('frontend.shop.show', compact('product', 'relatedProducts'));
    }

    public function categories()
    {
        $categories = Category::where('status', true)->withCount('products')->get();
        return view('frontend.shop.categories', compact('categories'));
    }

    public function search(Request $request)
    {
        $query = $request->q;
        
        if (!$query) {
            return redirect()->route('shop');
        }

        $products = Product::where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->where('status', true)
            ->with('primaryImage')
            ->paginate(20);

        return view('frontend.shop.search', compact('products', 'query'));
    }
}
