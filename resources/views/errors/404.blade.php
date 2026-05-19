@extends('layouts.frontend.app')

@section('title', 'পেজ পাওয়া যায়নি')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-16">
    <div class="text-center max-w-md">
        <div class="text-8xl font-bold text-primary-600 mb-4">৪০৪</div>
        <h1 class="text-2xl font-bold text-gray-800 mb-3">পেজটি পাওয়া যায়নি!</h1>
        <p class="text-gray-500 mb-8">আপনি যে পেজটি খুঁজছেন সেটি সরানো হয়েছে, নাম পরিবর্তন হয়েছে অথবা কখনও ছিল না।</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('home') }}"
               class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-xl font-medium transition">
                হোমে ফিরুন
            </a>
            <a href="{{ route('shop') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium transition">
                কেনাকাটা করুন
            </a>
        </div>
    </div>
</div>
@endsection
