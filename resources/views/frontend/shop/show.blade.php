@extends('layouts.frontend.app')

@section('title', $product->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">হোম</a>
        <span class="mx-2">/</span>
        @if($product->category)
        <a href="{{ route('category', $product->category->slug) }}" class="text-gray-500 hover:text-gray-700">{{ $product->category->name }}</a>
        <span class="mx-2">/</span>
        @endif
        <span class="text-gray-800">{{ $product->name }}</span>
    </nav>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Product Images -->
        <div>
            <div class="bg-white rounded-xl p-4 shadow-sm mb-4">
                <img src="{{ $product->primaryImageUrl }}" alt="{{ $product->name }}" class="w-full h-96 object-contain" id="mainImage">
            </div>
            @if($product->images->count() > 1)
            <div class="grid grid-cols-4 gap-2">
                @foreach($product->images as $image)
                <img src="{{ $image->getImageUrlAttribute() }}" alt="{{ $product->name }}" 
                     class="w-full h-20 object-cover rounded-lg cursor-pointer border-2 hover:border-primary-500"
                     onclick="changeMainImage('{{ $image->getImageUrlAttribute() }}')">
                @endforeach
            </div>
            @endif
        </div>
        
        <!-- Product Info -->
        <div>
            <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>
            
            <div class="flex items-center space-x-4 mb-4">
                <div class="flex items-center">
                    <span class="text-yellow-400 text-xl">★</span>
                    <span class="ml-1 text-gray-600">{{ $product->rating }}</span>
                    <span class="ml-1 text-gray-400">({{ $product->review_count }} রিভিউ)</span>
                </div>
                @if($product->sold_count > 0)
                <span class="text-gray-500">{{ $product->sold_count }} বিক্রি</span>
                @endif
            </div>
            
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                <div class="flex items-center space-x-4">
                    <span class="text-3xl font-bold text-primary-600">{{ formatPrice($product->final_price) }}</span>
                    @if($product->discount_price)
                    <span class="text-xl text-gray-400 line-through">{{ formatPrice($product->price) }}</span>
                    <span class="bg-red-500 text-white px-2 py-1 rounded text-sm">-{{ $product->discount_percentage }}%</span>
                    @endif
                </div>
            </div>
            
            @if($product->short_description)
            <p class="text-gray-600 mb-6">{{ $product->short_description }}</p>
            @endif
            
            <!-- Stock Status -->
            @if($product->isInStock())
            <div class="flex items-center text-green-600 mb-6">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>স্টকে আছে ({{ $product->stock }} পিস)</span>
            </div>
            @else
            <div class="flex items-center text-red-600 mb-6">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span>স্টকে নেই</span>
            </div>
            @endif
            
            <!-- Quantity -->
            <div class="flex items-center space-x-4 mb-6">
                <label class="font-medium">পরিমাণ:</label>
                <div class="flex items-center border rounded-lg">
                    <button onclick="decrementQty()" class="px-4 py-2 hover:bg-gray-100">-</button>
                    <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-16 text-center border-0 outline-none">
                    <button onclick="incrementQty()" class="px-4 py-2 hover:bg-gray-100">+</button>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex space-x-4 mb-6">
                <button onclick="addToCart({{ $product->id }})" class="flex-1 btn-primary">কার্টে যোগ করুন</button>
                <button onclick="buyNow({{ $product->id }})" class="flex-1 btn-secondary">এখনই কিনুন</button>
            </div>
            
            <button onclick="addToWishlist({{ $product->id }})" class="flex items-center justify-center w-full border-2 border-gray-300 rounded-lg py-3 hover:border-primary-500 hover:text-primary-500 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                উইশলিস্টে যোগ করুন
            </button>
        </div>
    </div>
    
    <!-- Product Description -->
    @if($product->description)
    <div class="mt-12 bg-white rounded-xl p-6 shadow-sm">
        <h2 class="text-xl font-bold mb-4">পণ্যের বিবরণ</h2>
        <div class="prose max-w-none text-gray-600">
            {!! $product->description !!}
        </div>
    </div>
    @endif
    
    <!-- Reviews -->
    <div class="mt-12 bg-white rounded-xl p-6 shadow-sm">
        <h2 class="text-xl font-bold mb-6">গ্রাহক রিভিউ</h2>
        @if($product->reviews->count() > 0)
        <div class="space-y-6">
            @foreach($product->reviews as $review)
            <div class="border-b pb-6">
                <div class="flex items-center space-x-4 mb-2">
                    <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 font-semibold">
                        {{ $review->user->name[0] }}
                    </div>
                    <div>
                        <h4 class="font-medium">{{ $review->user->name }}</h4>
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                            @endfor
                        </div>
                    </div>
                </div>
                @if($review->comment)
                <p class="text-gray-600">{{ $review->comment }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 text-center py-8">এখনো কোন রিভিয়ু নেই।</p>
        @endif
    </div>
    
    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="mt-12">
        <h2 class="text-xl font-bold mb-6">সম্পর্কিত পণ্য</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($relatedProducts as $relatedProduct)
            @include('frontend.components.product-card', ['product' => $relatedProduct])
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
function changeMainImage(src) {
    document.getElementById('mainImage').src = src;
}

function incrementQty() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.max);
    if (parseInt(input.value) < max) {
        input.value = parseInt(input.value) + 1;
    }
}

function decrementQty() {
    const input = document.getElementById('quantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

async function addToCart(productId) {
    const quantity = document.getElementById('quantity').value;
    try {
        const response = await fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity,
            }),
        });
        const data = await response.json();
        if (data.success) {
            showToast(data.message, 'success');
            // Update cart count
            document.querySelectorAll('[data-cart-count]').forEach(el => {
                el.textContent = data.cart_count;
            });
        } else {
            showToast(data.message, 'error');
        }
    } catch (error) {
        showToast('সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'error');
    }
}

async function buyNow(productId) {
    await addToCart(productId);
    window.location.href = '/checkout';
}

async function addToWishlist(productId) {
    try {
        const response = await fetch('/wishlist/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ product_id: productId }),
        });
        const data = await response.json();
        showToast(data.message, data.success ? 'success' : 'error');
    } catch (error) {
        showToast('সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'error');
    }
}
</script>
@endpush
@endsection
