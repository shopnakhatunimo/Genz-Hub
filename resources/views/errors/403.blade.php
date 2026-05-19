@extends('layouts.frontend.app')

@section('title', 'অনুমতি নেই')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-16">
    <div class="text-center max-w-md">
        <div class="text-8xl font-bold text-yellow-500 mb-4">৪০৩</div>
        <h1 class="text-2xl font-bold text-gray-800 mb-3">অ্যাক্সেস অনুমোদিত নয়!</h1>
        <p class="text-gray-500 mb-8">আপনার এই পেজটি দেখার অনুমতি নেই।</p>
        <a href="{{ route('home') }}"
           class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-xl font-medium transition">
            হোমে ফিরুন
        </a>
    </div>
</div>
@endsection
