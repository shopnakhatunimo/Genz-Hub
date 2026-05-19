@extends('layouts.admin.app')

@section('title', 'পণ্যসমূহ')
@section('header', 'পণ্যসমূহ')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.products.create') }}" class="btn-primary">নতুন পণ্য যোগ করুন</a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">পণ্য</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ক্যাটাগরি</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">দাম</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">স্টক</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">স্ট্যাটাস</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">অ্যাকশন</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($products as $product)
            <tr>
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <img src="{{ $product->primaryImageUrl }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
                        <div>
                            <p class="font-medium">{{ $product->name }}</p>
                            <p class="text-sm text-gray-500">{{ $product->sku }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">{{ $product->category->name ?? '-' }}</td>
                <td class="px-6 py-4 font-medium">{{ formatPrice($product->final_price) }}</td>
                <td class="px-6 py-4">{{ $product->stock }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded {{ $product->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $product->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->links() }}
</div>
@endsection
