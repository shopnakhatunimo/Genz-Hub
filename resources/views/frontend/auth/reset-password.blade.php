@extends('layouts.frontend.app')

@section('title', 'নতুন পাসওয়ার্ড সেট করুন')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <div class="text-center mb-8">
                <a href="{{ route('home') }}">
                    <img src="{{ getLogo() }}" alt="{{ getSiteName() }}" class="h-12 mx-auto mb-4">
                </a>
                <h1 class="text-2xl font-bold text-gray-800">নতুন পাসওয়ার্ড সেট করুন</h1>
            </div>

            @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">{{ session('error') }}</div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ইমেইল *</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="input-field" required>
                    @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">নতুন পাসওয়ার্ড *</label>
                    <input type="password" name="password" class="input-field" placeholder="কমপক্ষে ৮ অক্ষর" required>
                    @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">পাসওয়ার্ড নিশ্চিত করুন *</label>
                    <input type="password" name="password_confirmation" class="input-field" required>
                </div>
                <button type="submit" class="btn-primary w-full">পাসওয়ার্ড পরিবর্তন করুন</button>
            </form>
        </div>
    </div>
</div>
@endsection
