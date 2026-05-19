@extends('layouts.frontend.app')

@section('title', 'পেজের মেয়াদ শেষ')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-16">
    <div class="text-center max-w-md">
        <div class="text-7xl mb-4">⏰</div>
        <h1 class="text-2xl font-bold text-gray-800 mb-3">পেজের মেয়াদ শেষ হয়েছে!</h1>
        <p class="text-gray-500 mb-8">নিরাপত্তার জন্য পেজটির মেয়াদ শেষ হয়ে গেছে। অনুগ্রহ করে আবার চেষ্টা করুন।</p>
        <button onclick="history.back()"
           class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-xl font-medium transition">
            ফিরে যান
        </button>
    </div>
</div>
@endsection
