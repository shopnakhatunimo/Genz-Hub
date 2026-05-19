<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $query = Product::with('category', 'subcategory');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(20);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('status', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku',
            'brand' => 'nullable|string|max:100',
            'variants' => 'nullable|array',
            'is_featured' => 'nullable|boolean',
            'is_trending' => 'nullable|boolean',
            'is_flash_sale' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_image' => 'required|integer',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'sku' => $request->sku,
            'brand' => $request->brand,
            'variants' => $request->variants,
            'is_featured' => $request->is_featured ?? false,
            'is_trending' => $request->is_trending ?? false,
            'is_flash_sale' => $request->is_flash_sale ?? false,
            'status' => $request->status ?? true,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imageName = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products'), $imageName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imageName,
                    'order' => $index,
                    'is_primary' => $index == $request->primary_image,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'পণ্য সফলভাবে যোগ করা হয়েছে।');
    }

    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::where('status', true)->get();
        $subcategories = Subcategory::where('category_id', $product->category_id)->get();

        return view('admin.products.edit', compact('product', 'categories', 'subcategories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku,' . $id,
            'brand' => 'nullable|string|max:100',
            'variants' => 'nullable|array',
            'is_featured' => 'nullable|boolean',
            'is_trending' => 'nullable|boolean',
            'is_flash_sale' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_image' => 'nullable|integer',
        ]);

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'sku' => $request->sku,
            'brand' => $request->brand,
            'variants' => $request->variants,
            'is_featured' => $request->is_featured ?? false,
            'is_trending' => $request->is_trending ?? false,
            'is_flash_sale' => $request->is_flash_sale ?? false,
            'status' => $request->status ?? true,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imageName = time() . '_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products'), $imageName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imageName,
                    'order' => $product->images->count() + $index,
                    'is_primary' => $request->primary_image == $index,
                ]);
            }
        }

        if ($request->primary_image !== null) {
            $product->images()->update(['is_primary' => false]);
            $product->images[$request->primary_image]->update(['is_primary' => true]);
        }

        return redirect()->route('admin.products.index')->with('success', 'পণ্য সফলভাবে আপডেট করা হয়েছে।');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        foreach ($product->images as $image) {
            if (file_exists(public_path('uploads/products/' . $image->image))) {
                unlink(public_path('uploads/products/' . $image->image));
            }
            $image->delete();
        }

        $product->delete();

        return redirect()->back()->with('success', 'পণ্য সফলভাবে মুছে ফেলা হয়েছে।');
    }

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        
        if (file_exists(public_path('uploads/products/' . $image->image))) {
            unlink(public_path('uploads/products/' . $image->image));
        }

        $image->delete();

        return response()->json(['success' => true]);
    }

    public function getSubcategories(Request $request)
    {
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        return response()->json($subcategories);
    }
}
