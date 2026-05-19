@extends('layouts.frontend.app')

@section('title', $category->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6 text-sm text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-primary-600">হোম</a>
        <span class="mx-2">/</span>
        <span class="text-gray-800">{{ $category->name }}</span>
    </div>
    <h1 class="text-2xl font-bold mb-6">{{ $category->name }}</h1>
    @if($products->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($products as $product)
            @include('frontend.components.product-card', ['product' => $product])
        @endforeach
    </div>
    <div class="mt-8">{{ $products->links() }}</div>
    @else
    <div class="text-center py-16">
        <p class="text-gray-500 text-lg">এই ক্যাটাগরিতে কোনো পণ্য নেই।</p>
        <a href="{{ route('shop') }}" class="btn-primary mt-4 inline-block">সব পণ্য দেখুন</a>
    </div>
    @endif
</div>
@endsection
