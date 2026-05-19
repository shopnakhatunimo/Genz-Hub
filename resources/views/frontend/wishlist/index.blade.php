@extends('layouts.frontend.app')

@section('title', 'আমার উইশলিস্ট')

@section('content')
<div class="pt-16 pb-20 lg:pt-20 lg:pb-8">
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">❤️ আমার উইশলিস্ট</h1>

        @if($wishlists->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($wishlists as $item)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden group" id="wishlist-item-{{ $item->id }}">
                <div class="relative">
                    <a href="{{ route('product.show', $item->product->slug) }}">
                        <img src="{{ $item->product->main_image_url }}"
                             alt="{{ $item->product->name }}"
                             class="w-full h-44 object-cover group-hover:scale-105 transition duration-300"
                             loading="lazy">
                    </a>
                    {{-- Remove from wishlist --}}
                    <button onclick="removeFromWishlist({{ $item->product_id }}, {{ $item->id }})"
                            class="absolute top-2 right-2 w-8 h-8 bg-white rounded-full shadow flex items-center justify-center hover:bg-red-50 transition">
                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                        </svg>
                    </button>
                </div>
                <div class="p-3">
                    <a href="{{ route('product.show', $item->product->slug) }}" class="block">
                        <h3 class="font-medium text-gray-800 text-sm line-clamp-2 mb-2 hover:text-primary-600 transition">
                            {{ $item->product->name }}
                        </h3>
                        <div class="flex items-center gap-2">
                            <span class="text-primary-600 font-bold text-sm">
                                {{ formatPrice($item->product->sale_price ?? $item->product->price) }}
                            </span>
                            @if($item->product->sale_price)
                            <span class="text-gray-400 line-through text-xs">{{ formatPrice($item->product->price) }}</span>
                            @endif
                        </div>
                    </a>
                    <button onclick="addToCart({{ $item->product_id }})"
                            class="mt-3 w-full bg-primary-600 hover:bg-primary-700 text-white py-1.5 rounded-lg text-sm font-medium transition">
                        কার্টে যোগ করুন
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-20">
            <div class="text-6xl mb-4">💔</div>
            <h2 class="text-xl font-semibold text-gray-700 mb-2">উইশলিস্ট খালি</h2>
            <p class="text-gray-400 mb-6">আপনার পছন্দের পণ্যগুলো এখানে সেভ করুন।</p>
            <a href="{{ route('shop') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-xl font-medium transition">
                কেনাকাটা করুন
            </a>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function removeFromWishlist(productId, itemId) {
    fetch('{{ route("wishlist.remove") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ product_id: productId }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('wishlist-item-' + itemId).remove();
            showToast('উইশলিস্ট থেকে সরানো হয়েছে।', 'info');
        }
    });
}

function addToCart(productId) {
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ product_id: productId, quantity: 1 }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast('পণ্যটি কার্টে যোগ করা হয়েছে।', 'success');
            const badge = document.querySelector('.cart-count');
            if (badge) badge.textContent = data.count;
        }
    });
}

function showToast(msg, type) {
    const colors = { success: 'bg-green-600', info: 'bg-blue-600', error: 'bg-red-600' };
    const toast = document.createElement('div');
    toast.className = `fixed bottom-20 left-1/2 -translate-x-1/2 ${colors[type] || 'bg-gray-800'} text-white px-5 py-2.5 rounded-full text-sm shadow-lg z-50 transition`;
    toast.textContent = msg;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
</script>
@endpush
@endsection
