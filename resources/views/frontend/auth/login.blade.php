@extends('layouts.frontend.app')

@section('title', 'লগইন')

@section('content')
<div class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full bg-white rounded-xl p-8 shadow-sm">
        <h1 class="text-2xl font-bold text-center mb-6">লগইন করুন</h1>
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">ইমেইল</label>
                    <input type="email" name="email" required class="input-field">
                    @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">পাসওয়ার্ড</label>
                    <input type="password" name="password" required class="input-field">
                    @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="mr-2">
                        <span class="text-sm">মনে রাখুন</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:underline">পাসওয়ার্ড ভুলে গেছেন?</a>
                </div>
                <button type="submit" class="w-full btn-primary">লগইন</button>
            </div>
        </form>
        
        <p class="text-center mt-6 text-gray-600">
            অ্যাকাউন্ট নেই? <a href="{{ route('register') }}" class="text-primary-600 hover:underline">রেজিস্টার করুন</a>
        </p>
    </div>
</div>
@endsection
