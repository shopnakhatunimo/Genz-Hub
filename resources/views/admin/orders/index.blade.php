@extends('layouts.admin.app')

@section('title', 'অর্ডারসমূহ')
@section('header', 'অর্ডারসমূহ')

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">অর্ডার নম্বর</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">গ্রাহক</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">মোট</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">স্ট্যাটাস</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">তারিখ</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">অ্যাকশন</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($orders as $order)
            <tr>
                <td class="px-6 py-4 font-medium">{{ $order->order_number }}</td>
                <td class="px-6 py-4">{{ $order->name }}</td>
                <td class="px-6 py-4 font-medium">{{ formatPrice($order->total) }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                        {{ $order->status_label }}
                    </span>
                </td>
                <td class="px-6 py-4">{{ $order->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-800">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->links() }}
</div>
@endsection
