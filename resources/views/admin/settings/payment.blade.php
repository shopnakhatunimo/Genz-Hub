@extends('layouts.admin.app')

@section('title', 'পেমেন্ট সেটিংস')
@section('header', 'পেমেন্ট সেটিংস')

@section('content')
@if(session('success'))
<div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
@endif

<div class="max-w-2xl">
    <div class="bg-white rounded-xl p-6 shadow-sm">
        <form action="{{ route('admin.settings.payment.update') }}" method="POST" class="space-y-6">
            @csrf
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <h3 class="font-semibold">ক্যাশ অন ডেলিভারি</h3>
                    <p class="text-sm text-gray-500">ডেলিভারির সময় নগদ পেমেন্ট</p>
                </div>
                <label class="flex items-center">
                    <input type="hidden" name="cash_on_delivery" value="0">
                    <input type="checkbox" name="cash_on_delivery" value="1" {{ getSetting('cash_on_delivery', '1') === '1' ? 'checked' : '' }} class="w-5 h-5">
                </label>
            </div>
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <h3 class="font-semibold">অনলাইন পেমেন্ট</h3>
                    <p class="text-sm text-gray-500">bKash, Nagad পেমেন্ট</p>
                </div>
                <label class="flex items-center">
                    <input type="hidden" name="online_payment" value="0">
                    <input type="checkbox" name="online_payment" value="1" {{ getSetting('online_payment', '0') === '1' ? 'checked' : '' }} class="w-5 h-5">
                </label>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">bKash Merchant Key</label>
                <input type="text" name="bkash_merchant_key" value="{{ getSetting('bkash_merchant_key') }}" class="input-field" placeholder="bKash Merchant API Key">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Nagad Merchant Key</label>
                <input type="text" name="nagad_merchant_key" value="{{ getSetting('nagad_merchant_key') }}" class="input-field" placeholder="Nagad Merchant API Key">
            </div>
            <button type="submit" class="btn-primary">সংরক্ষণ করুন</button>
        </form>
    </div>
</div>
@endsection
