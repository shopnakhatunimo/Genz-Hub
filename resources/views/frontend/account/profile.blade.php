@extends('layouts.frontend.app')

@section('title', 'প্রোফাইল সম্পাদনা')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        @include('frontend.account._sidebar')
        <div class="lg:col-span-3 space-y-6">
            @if(session('success'))
            <div class="p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold mb-6">প্রোফাইল তথ্য</h2>
                <form action="{{ route('account.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">পূর্ণ নাম *</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input-field" required>
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">ইমেইল *</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input-field" required>
                            @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">ফোন নম্বর</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="input-field">
                        </div>
                    </div>
                    <button type="submit" class="btn-primary">প্রোফাইল আপডেট করুন</button>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold mb-6">পাসওয়ার্ড পরিবর্তন</h2>
                <form action="{{ route('account.password.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium mb-1">বর্তমান পাসওয়ার্ড *</label>
                        <input type="password" name="current_password" class="input-field" required>
                        @error('current_password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">নতুন পাসওয়ার্ড *</label>
                        <input type="password" name="password" class="input-field" required>
                        @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">নতুন পাসওয়ার্ড নিশ্চিত করুন *</label>
                        <input type="password" name="password_confirmation" class="input-field" required>
                    </div>
                    <button type="submit" class="btn-primary">পাসওয়ার্ড পরিবর্তন করুন</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
