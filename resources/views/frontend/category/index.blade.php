@extends('layouts.frontend.app')

@section('title', 'সকল ক্যাটাগরি')

@section('content')
<div class="pt-16 pb-20 lg:pt-20 lg:pb-8">
    <div class="container mx-auto px-4 py-6">

        {{-- Page Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">সকল ক্যাটাগরি</h1>
            <p class="text-gray-500 text-sm mt-1">আপনার পছন্দের ক্যাটাগরি থেকে পণ্য খুঁজুন</p>
        </div>

        {{-- Categories Grid --}}
        @if($categories->count() > 0)
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-4">
            @foreach($categories as $category)
            <a href="{{ route('category', $category->slug) }}"
               class="group bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden text-center p-4">
                @if($category->image)
                <div class="w-16 h-16 mx-auto mb-3 rounded-full overflow-hidden bg-gray-100">
                    <img src="{{ asset('uploads/categories/' . $category->image) }}"
                         alt="{{ $category->name }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                         loading="lazy">
                </div>
                @else
                <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-primary-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                </div>
                @endif
                <h3 class="text-sm font-medium text-gray-700 group-hover:text-primary-600 transition line-clamp-2">
                    {{ $category->name }}
                </h3>
                <p class="text-xs text-gray-400 mt-1">{{ $category->products_count ?? 0 }} পণ্য</p>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-16">
            <p class="text-gray-500">কোনো ক্যাটাগরি পাওয়া যায়নি।</p>
        </div>
        @endif

    </div>
</div>
@endsection
