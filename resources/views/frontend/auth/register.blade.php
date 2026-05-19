@extends('layouts.frontend.app')

@section('title', 'রেজিস্ট্রেশন')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <div class="text-center mb-8">
                <a href="{{ route('home') }}">
                    <img src="{{ getLogo() }}" alt="{{ getSiteName() }}" class="h-12 mx-auto mb-4">
                </a>
                <h1 class="text-2xl font-bold text-gray-800">নতুন অ্যাকাউন্ট তৈরি করুন</h1>
                <p class="text-gray-500 mt-1">আপনার তথ্য দিয়ে রেজিস্ট্রেশন করুন</p>
            </div>

            @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">{{ session('error') }}</div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">পূর্ণ নাম *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="input-field" placeholder="আপনার নাম" required autofocus>
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ইমেইল *</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="input-field" placeholder="example@email.com" required>
                    @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ফোন নম্বর</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="input-field" placeholder="01XXXXXXXXX">
                    @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">পাসওয়ার্ড *</label>
                    <input type="password" name="password" class="input-field" placeholder="কমপক্ষে ৮ অক্ষর" required>
                    @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">পাসওয়ার্ড নিশ্চিত করুন *</label>
                    <input type="password" name="password_confirmation" class="input-field" placeholder="পাসওয়ার্ড আবার লিখুন" required>
                </div>
                <button type="submit" class="btn-primary w-full">রেজিস্ট্রেশন করুন</button>
            </form>

            <p class="text-center text-gray-500 mt-6">
                ইতিমধ্যে অ্যাকাউন্ট আছে?
                <a href="{{ route('login') }}" class="text-primary-600 font-medium hover:underline">লগইন করুন</a>
            </p>
        </div>
    </div>
</div>
@endsection
