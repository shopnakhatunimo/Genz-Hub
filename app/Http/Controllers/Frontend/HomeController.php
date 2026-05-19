<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $heroBanners = Banner::active()->where('type', 'hero')->orderBy('order')->get();
        $promoBanners = Banner::active()->where('type', 'promo')->orderBy('order')->get();
        
        $featuredCategories = Category::where('is_featured', true)->where('status', true)->get();
        $featuredProducts = Product::where('is_featured', true)->where('status', true)->with('primaryImage')->take(8)->get();
        $trendingProducts = Product::where('is_trending', true)->where('status', true)->with('primaryImage')->take(8)->get();
        $flashSaleProducts = Product::where('is_flash_sale', true)->where('status', true)->with('primaryImage')->take(8)->get();
        
        $newProducts = Product::where('status', true)->with('primaryImage')->latest()->take(12)->get();
        
        return view('frontend.home.index', compact(
            'heroBanners',
            'promoBanners',
            'featuredCategories',
            'featuredProducts',
            'trendingProducts',
            'flashSaleProducts',
            'newProducts'
        ));
    }

    public function about()
    {
        return view('frontend.pages.about');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        \App\Models\Contact::create($request->all());

        return redirect()->back()->with('success', 'আপনার বার্তা সফলভাবে পাঠানো হয়েছে। আমরা শীঘ্রই আপনার সাথে যোগাযোগ করব।');
    }

    public function newsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletters,email',
        ]);

        \App\Models\Newsletter::create([
            'email' => $request->email,
            'subscribed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'আপনি সফলভাবে নিউজলেটারে সাবস্ক্রাইব করেছেন।');
    }
}
