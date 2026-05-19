@extends('layouts.admin.app')

@section('title', 'সাবক্যাটাগরি সম্পাদনা')
@section('header', 'সাবক্যাটাগরি সম্পাদনা')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl p-6 shadow-sm">
        <form action="{{ route('admin.subcategories.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium mb-1">ক্যাটাগরি *</label>
                <select name="category_id" class="input-field" required>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">নাম *</label>
                <input type="text" name="name" value="{{ old('name', $subcategory->name) }}" class="input-field" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">বিবরণ</label>
                <textarea name="description" class="input-field" rows="2">{{ old('description', $subcategory->description) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">ছবি পরিবর্তন করুন</label>
                @if($subcategory->image)
                <img src="{{ asset('uploads/categories/' . $subcategory->image) }}" alt="{{ $subcategory->name }}" class="h-12 mb-2 rounded">
                @endif
                <input type="file" name="image" accept="image/*" class="input-field">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">ক্রম</label>
                    <input type="number" name="order" value="{{ old('order', $subcategory->order) }}" class="input-field">
                </div>
                <div class="flex items-center mt-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="status" value="1" {{ $subcategory->status ? 'checked' : '' }} class="mr-2"> সক্রিয়
                    </label>
                </div>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="btn-primary">আপডেট করুন</button>
                <a href="{{ route('admin.subcategories.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50">বাতিল</a>
            </div>
        </form>
    </div>
</div>
@endsection
