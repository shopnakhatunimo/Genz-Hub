@extends('layouts.frontend.app')

@section('title', 'পাসওয়ার্ড পরিবর্তন')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        @include('frontend.account._sidebar')
        <div class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold mb-6">পাসওয়ার্ড পরিবর্তন</h2>
                @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">{{ session('error') }}</div>
                @endif
                <form action="{{ route('account.password.update') }}" method="POST" class="max-w-md space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium mb-1">বর্তমান পাসওয়ার্ড *</label>
                        <input type="password" name="current_password" class="input-field" required>
                        @error('current_password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">নতুন পাসওয়ার্ড *</label>
                        <input type="password" name="password" class="input-field" placeholder="কমপক্ষে ৮ অক্ষর" required>
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
