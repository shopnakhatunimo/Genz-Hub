@props(['product'])

<div class="card overflow-hidden group">
    <div class="relative">
        <a href="{{ route('product.show', $product->slug) }}">
            <img src="{{ $product->primaryImageUrl }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
        </a>
        @if($product->discount_price)
        <span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded">-{{ $product->discount_percentage }}%</span>
        @endif
        <button onclick="addToWishlist({{ $product->id }})" class="absolute top-2 right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow hover:bg-red-50 transition-colors">
            <svg class="w-5 h-5 text-gray-400 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
        </button>
    </div>
    <div class="p-4">
        <a href="{{ route('product.show', $product->slug) }}">
            <h3 class="font-medium text-gray-800 mb-2 line-clamp-2 h-12">{{ $product->name }}</h3>
            <div class="flex items-center space-x-2 mb-2">
                <span class="text-lg font-bold text-primary-600">{{ formatPrice($product->final_price) }}</span>
                @if($product->discount_price)
                <span class="text-sm text-gray-400 line-through">{{ formatPrice($product->price) }}</span>
                @endif
            </div>
            <div class="flex items-center text-sm text-gray-500">
                <span class="text-yellow-400">★</span>
                <span class="ml-1">{{ $product->rating }} ({{ $product->review_count }})</span>
            </div>
        </a>
        <button onclick="addToCart({{ $product->id }})" class="w-full mt-3 btn-primary text-sm">কার্টে যোগ করুন</button>
    </div>
</div>
