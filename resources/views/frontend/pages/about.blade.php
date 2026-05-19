@extends('layouts.frontend.app')

@section('title', 'আমাদের সম্পর্কে')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">আমাদের সম্পর্কে</h1>
    <div class="bg-white rounded-xl shadow-sm p-8">
        <p class="text-gray-600 text-lg leading-relaxed mb-4">
            আমরা একটি বিশ্বস্ত অনলাইন শপিং প্ল্যাটফর্ম যা আপনার কেনাকাটার অভিজ্ঞতাকে সহজ ও আনন্দময় করতে প্রতিশ্রুতিবদ্ধ।
        </p>
        <p class="text-gray-600 text-lg leading-relaxed mb-4">
            আমাদের লক্ষ্য হলো সর্বোচ্চ মানের পণ্য সাশ্রয়ী মূল্যে আপনার দোরগোড়ায় পৌঁছে দেওয়া।
        </p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="text-center p-6 bg-gray-50 rounded-xl">
                <div class="text-4xl font-bold text-primary-600 mb-2">১০০+</div>
                <div class="text-gray-600">পণ্য ক্যাটাগরি</div>
            </div>
            <div class="text-center p-6 bg-gray-50 rounded-xl">
                <div class="text-4xl font-bold text-primary-600 mb-2">৫০০০+</div>
                <div class="text-gray-600">সন্তুষ্ট গ্রাহক</div>
            </div>
            <div class="text-center p-6 bg-gray-50 rounded-xl">
                <div class="text-4xl font-bold text-primary-600 mb-2">২৪/৭</div>
                <div class="text-gray-600">কাস্টমার সাপোর্ট</div>
            </div>
        </div>
    </div>
</div>
@endsection
