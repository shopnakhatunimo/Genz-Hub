<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * পণ্যের তালিকা (API)
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::with(['category', 'images'])
            ->where('status', 'active');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('sort')) {
            match ($request->sort) {
                'price_asc'  => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                'newest'     => $query->latest(),
                default      => $query->latest(),
            };
        }

        $products = $query->paginate($request->get('per_page', 12));

        return response()->json([
            'success' => true,
            'data'    => $products,
        ]);
    }

    /**
     * একটি পণ্যের বিস্তারিত (API)
     */
    public function show(string $slug): JsonResponse
    {
        $product = Product::with(['category', 'subcategory', 'images', 'reviews'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data'    => $product,
        ]);
    }

    /**
     * ফিচারড পণ্য (API)
     */
    public function featured(): JsonResponse
    {
        $products = Product::with(['images'])
            ->where('status', 'active')
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $products,
        ]);
    }

    /**
     * লাইভ সার্চ (API)
     */
    public function search(Request $request): JsonResponse
    {
        $term = $request->get('q', '');

        if (strlen($term) < 2) {
            return response()->json(['success' => true, 'data' => []]);
        }

        $products = Product::with(['images'])
            ->where('status', 'active')
            ->where('name', 'like', '%' . $term . '%')
            ->limit(8)
            ->get(['id', 'name', 'slug', 'price', 'sale_price']);

        return response()->json([
            'success' => true,
            'data'    => $products,
        ]);
    }
}
