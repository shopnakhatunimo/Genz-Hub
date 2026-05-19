@extends('layouts.frontend.app')

@section('title', '"' . $query . '" অনুসন্ধান ফলাফল')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">"{{ $query }}" এর ফলাফল</h1>
        <p class="text-gray-500 mt-1">{{ $products->total() }} টি পণ্য পাওয়া গেছে</p>
    </div>
    <form action="{{ route('search') }}" method="GET" class="mb-8">
        <div class="flex gap-2">
            <input type="text" name="q" value="{{ $query }}" placeholder="পণ্য খুঁজুন..." class="input-field flex-1">
            <button type="submit" class="btn-primary px-6">খুঁজুন</button>
        </div>
    </form>
    @if($products->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($products as $product)
            @include('frontend.components.product-card', ['product' => $product])
        @endforeach
    </div>
    <div class="mt-8">{{ $products->links() }}</div>
    @else
    <div class="text-center py-16">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        <p class="text-gray-500 text-lg">কোনো পণ্য পাওয়া যায়নি।</p>
        <a href="{{ route('shop') }}" class="btn-primary mt-4 inline-block">সব পণ্য দেখুন</a>
    </div>
    @endif
</div>
@endsection
