@extends('layouts.frontend.app')

@section('title', 'দোকান')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Filters -->
        <aside class="lg:w-64 flex-shrink-0">
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h3 class="font-semibold text-lg mb-4">ফিল্টার</h3>
                
                <!-- Categories -->
                <div class="mb-6">
                    <h4 class="font-medium mb-3">ক্যাটাগরি</h4>
                    <div class="space-y-2">
                        @foreach($categories as $category)
                        <label class="flex items-center">
                            <input type="checkbox" name="category" value="{{ $category->id }}" class="mr-2">
                            <span>{{ $category->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Price Range -->
                <div class="mb-6">
                    <h4 class="font-medium mb-3">দাম</h4>
                    <div class="flex space-x-2">
                        <input type="number" placeholder="সর্বনিম্ন" class="input-field text-sm">
                        <input type="number" placeholder="সর্বোচ্চ" class="input-field text-sm">
                    </div>
                </div>
                
                <button class="w-full btn-primary">ফিল্টার প্রয়োগ করুন</button>
            </div>
        </aside>
        
        <!-- Products Grid -->
        <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">সব পণ্য</h1>
                <select class="input-field w-auto">
                    <option value="newest">নতুন</option>
                    <option value="price_low">দাম কম থেকে বেশি</option>
                    <option value="price_high">দাম বেশি থেকে কম</option>
                    <option value="popular">জনপ্রিয়</option>
                </select>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($products as $product)
                @include('frontend.components.product-card', ['product' => $product])
                @endforeach
            </div>
            
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
