@extends('layouts.frontend.app')

@section('title', 'পাসওয়ার্ড ভুলে গেছেন')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <div class="text-center mb-8">
                <a href="{{ route('home') }}">
                    <img src="{{ getLogo() }}" alt="{{ getSiteName() }}" class="h-12 mx-auto mb-4">
                </a>
                <h1 class="text-2xl font-bold text-gray-800">পাসওয়ার্ড রিসেট</h1>
                <p class="text-gray-500 mt-1">আপনার ইমেইল দিন, রিসেট লিঙ্ক পাঠানো হবে</p>
            </div>

            @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">{{ session('error') }}</div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ইমেইল ঠিকানা *</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="input-field" placeholder="example@email.com" required autofocus>
                    @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="btn-primary w-full">রিসেট লিঙ্ক পাঠান</button>
            </form>

            <p class="text-center text-gray-500 mt-6">
                <a href="{{ route('login') }}" class="text-primary-600 font-medium hover:underline">লগইনে ফিরে যান</a>
            </p>
        </div>
    </div>
</div>
@endsection
