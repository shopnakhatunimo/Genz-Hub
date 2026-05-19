<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $subcategories = Subcategory::with('category')->latest()->get();
        $categories = Category::all();
        return view('admin.subcategories.index', compact('subcategories', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('status', true)->get();
        return view('admin.subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $image = null;
        if ($request->hasFile('image')) {
            $image = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/categories'), $image);
        }

        Subcategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => $image,
            'order' => $request->order ?? 0,
            'status' => $request->status ?? true,
        ]);

        return redirect()->route('admin.subcategories.index')->with('success', 'সাবক্যাটাগরি সফলভাবে যোগ করা হয়েছে।');
    }

    public function edit($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $categories = Category::where('status', true)->get();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $subcategory = Subcategory::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'order' => $request->order ?? 0,
            'status' => $request->status ?? true,
        ];

        if ($request->hasFile('image')) {
            if ($subcategory->image && file_exists(public_path('uploads/categories/' . $subcategory->image))) {
                unlink(public_path('uploads/categories/' . $subcategory->image));
            }
            $data['image'] = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/categories'), $data['image']);
        }

        $subcategory->update($data);

        return redirect()->route('admin.subcategories.index')->with('success', 'সাবক্যাটাগরি সফলভাবে আপডেট করা হয়েছে।');
    }

    public function destroy($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        
        if ($subcategory->image && file_exists(public_path('uploads/categories/' . $subcategory->image))) {
            unlink(public_path('uploads/categories/' . $subcategory->image));
        }

        $subcategory->delete();

        return redirect()->back()->with('success', 'সাবক্যাটাগরি সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
