@extends('layouts.frontend.app')

@section('title', 'আমার ঠিকানাসমূহ')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        @include('frontend.account._sidebar')
        <div class="lg:col-span-3 space-y-6">
            @if(session('success'))
            <div class="p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold mb-6">নতুন ঠিকানা যোগ করুন</h2>
                <form action="{{ route('account.addresses.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">নাম *</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="input-field" required>
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">ফোন *</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="input-field" required>
                            @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1">ঠিকানা *</label>
                            <textarea name="address" class="input-field" rows="2" required>{{ old('address') }}</textarea>
                            @error('address')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">এলাকা *</label>
                            <input type="text" name="area" value="{{ old('area') }}" class="input-field" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">শহর *</label>
                            <input type="text" name="city" value="{{ old('city') }}" class="input-field" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">ল্যান্ডমার্ক</label>
                            <input type="text" name="landmark" value="{{ old('landmark') }}" class="input-field" placeholder="নিকটবর্তী পরিচিত স্থান (ঐচ্ছিক)">
                        </div>
                    </div>
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_default" value="1" class="mr-2"> ডিফল্ট ঠিকানা হিসেবে সেট করুন
                        </label>
                    </div>
                    <button type="submit" class="btn-primary">ঠিকানা সংরক্ষণ করুন</button>
                </form>
            </div>

            @if($addresses->count() > 0)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold mb-4">সংরক্ষিত ঠিকানাসমূহ</h2>
                <div class="space-y-4">
                    @foreach($addresses as $address)
                    <div class="border rounded-xl p-4 {{ $address->is_default ? 'border-primary-500' : '' }}">
                        <div class="flex items-start justify-between">
                            <div>
                                @if($address->is_default)
                                <span class="text-xs bg-primary-100 text-primary-700 px-2 py-0.5 rounded mb-2 inline-block">ডিফল্ট</span>
                                @endif
                                <p class="font-semibold">{{ $address->name }}</p>
                                <p class="text-gray-600 text-sm">{{ $address->phone }}</p>
                                <p class="text-gray-600 text-sm">{{ $address->full_address }}</p>
                            </div>
                            <div class="flex space-x-2">
                                @if(!$address->is_default)
                                <form action="{{ route('account.addresses.default', $address->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs text-primary-600 hover:underline">ডিফল্ট করুন</button>
                                </form>
                                @endif
                                <form action="{{ route('account.addresses.delete', $address->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-600 hover:underline" onclick="return confirm('মুছে ফেলবেন?')">মুছুন</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
