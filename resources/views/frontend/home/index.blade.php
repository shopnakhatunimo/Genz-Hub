@extends('layouts.frontend.app')

@section('title', 'হোম')

@section('content')
<!-- Hero Slider -->
<div class="relative overflow-hidden bg-gray-100">
    <div x-data="{ currentSlide: 0 }" class="relative">
        @if($heroBanners->count() > 0)
        @foreach($heroBanners as $index => $banner)
        <div x-show="currentSlide === {{ $index }}" class="w-full h-64 md:h-96 lg:h-[500px] bg-gray-200">
            <img src="{{ $banner->getImageUrlAttribute() }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                <div class="text-center text-white px-4">
                    <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold mb-4">{{ $banner->title }}</h1>
                    @if($banner->subtitle)
                    <p class="text-lg md:text-xl mb-6">{{ $banner->subtitle }}</p>
                    @endif
                    @if($banner->link)
                    <a href="{{ $banner->link }}" class="btn-primary inline-block">এখনই কিনুন</a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
        
        <!-- Slider Navigation -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
            @foreach($heroBanners as $index => $banner)
            <button @click="currentSlide = {{ $index }}" :class="currentSlide === {{ $index }} ? 'bg-white' : 'bg-white/50'" class="w-3 h-3 rounded-full"></button>
            @endforeach
        </div>
        @endif
    </div>
</div>

<!-- Featured Categories -->
@if($featuredCategories->count() > 0)
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center">জনপ্রিয় ক্যাটাগরি</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($featuredCategories as $category)
            <a href="{{ route('category', $category->slug) }}" class="card p-4 text-center hover:shadow-lg transition-shadow">
                <img src="{{ $category->getImageUrlAttribute() }}" alt="{{ $category->name }}" class="w-20 h-20 mx-auto mb-3 rounded-full object-cover">
                <h3 class="font-medium text-gray-800">{{ $category->name }}</h3>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Flash Sale -->
@if($flashSaleProducts->count() > 0)
<section class="py-12 bg-gradient-to-r from-red-500 to-orange-500">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-white">⚡ ফ্ল্যাশ সেল</h2>
            <a href="{{ route('shop') }}" class="text-white hover:underline">সব দেখুন</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($flashSaleProducts as $product)
            <div class="bg-white rounded-xl p-4 shadow-lg">
                <a href="{{ route('product.show', $product->slug) }}">
                    <img src="{{ $product->primaryImageUrl }}" alt="{{ $product->name }}" class="w-full h-32 object-cover rounded-lg mb-3">
                    <h3 class="font-medium text-gray-800 text-sm mb-2 line-clamp-2">{{ $product->name }}</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-lg font-bold text-red-600">{{ formatPrice($product->final_price) }}</span>
                        @if($product->discount_price)
                        <span class="text-sm text-gray-400 line-through">{{ formatPrice($product->price) }}</span>
                        @endif
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Featured Products -->
@if($featuredProducts->count() > 0)
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center">ফিচারড পণ্য</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($featuredProducts as $product)
            @include('frontend.components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Trending Products -->
@if($trendingProducts->count() > 0)
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center">ট্রেন্ডিং পণ্য</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($trendingProducts as $product)
            @include('frontend.components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- New Products -->
@if($newProducts->count() > 0)
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center">নতুন পণ্য</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($newProducts as $product)
            @include('frontend.components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Promo Banners -->
@if($promoBanners->count() > 0)
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($promoBanners as $banner)
            <a href="{{ $banner->link ?? '#' }}" class="relative rounded-xl overflow-hidden">
                <img src="{{ $banner->getImageUrlAttribute() }}" alt="{{ $banner->title }}" class="w-full h-48 object-cover">
                <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                    <h3 class="text-xl font-bold text-white">{{ $banner->title }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
