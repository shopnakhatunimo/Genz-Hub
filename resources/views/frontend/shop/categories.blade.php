@extends('layouts.frontend.app')

@section('title', 'সব ক্যাটাগরি')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">সব ক্যাটাগরি</h1>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
        @foreach($categories as $category)
        <a href="{{ route('category', $category->slug) }}" class="bg-white rounded-xl p-4 text-center shadow-sm hover:shadow-md transition-shadow group">
            <img src="{{ $category->getImageUrlAttribute() }}" alt="{{ $category->name }}" class="w-20 h-20 mx-auto mb-3 rounded-full object-cover group-hover:scale-105 transition-transform">
            <h3 class="font-medium text-gray-800 text-sm">{{ $category->name }}</h3>
            <p class="text-xs text-gray-400 mt-1">{{ $category->products_count }} টি পণ্য</p>
        </a>
        @endforeach
    </div>
</div>
@endsection
