@extends('layouts.frontend.app')

@section('title', 'উইশলিস্ট')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        @include('frontend.account._sidebar')
        <div class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold mb-6">আমার উইশলিস্ট</h2>
                @if($wishlist->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($wishlist as $item)
                    <div class="border rounded-xl overflow-hidden group">
                        <div class="relative">
                            <img src="{{ $item->product->primaryImageUrl }}" alt="{{ $item->product->name }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform">
                        </div>
                        <div class="p-4">
                            <h3 class="font-medium mb-1">{{ $item->product->name }}</h3>
                            <p class="text-primary-600 font-bold mb-3">{{ formatPrice($item->product->final_price) }}</p>
                            <div class="flex space-x-2">
                                <a href="{{ route('product.show', $item->product->slug) }}" class="flex-1 btn-primary text-center text-sm py-2">দেখুন</a>
                                <form action="{{ route('wishlist.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                    <button type="submit" class="px-3 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    <p class="text-gray-500">উইশলিস্ট ফাঁকা</p>
                    <a href="{{ route('shop') }}" class="btn-primary mt-4 inline-block">কেনাকাটা করুন</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
