@extends('layouts.frontend.app')

@section('title', 'সার্ভার ত্রুটি')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-16">
    <div class="text-center max-w-md">
        <div class="text-8xl font-bold text-red-500 mb-4">৫০০</div>
        <h1 class="text-2xl font-bold text-gray-800 mb-3">সার্ভারে সমস্যা হয়েছে!</h1>
        <p class="text-gray-500 mb-8">দুঃখিত, সার্ভারে একটি অপ্রত্যাশিত সমস্যা হয়েছে। আমরা দ্রুত সমাধান করার চেষ্টা করছি।</p>
        <a href="{{ route('home') }}"
           class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-xl font-medium transition">
            হোমে ফিরুন
        </a>
    </div>
</div>
@endsection
