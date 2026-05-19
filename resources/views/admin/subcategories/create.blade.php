@extends('layouts.admin.app')

@section('title', 'নতুন সাবক্যাটাগরি')
@section('header', 'নতুন সাবক্যাটাগরি যোগ করুন')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl p-6 shadow-sm">
        <form action="{{ route('admin.subcategories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">ক্যাটাগরি *</label>
                <select name="category_id" class="input-field" required>
                    <option value="">ক্যাটাগরি বেছে নিন</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">নাম *</label>
                <input type="text" name="name" value="{{ old('name') }}" class="input-field" required>
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">বিবরণ</label>
                <textarea name="description" class="input-field" rows="2">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">ছবি</label>
                <input type="file" name="image" accept="image/*" class="input-field">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">ক্রম</label>
                    <input type="number" name="order" value="{{ old('order', 0) }}" class="input-field">
                </div>
                <div class="flex items-center mt-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }} class="mr-2"> সক্রিয়
                    </label>
                </div>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="btn-primary">সংরক্ষণ করুন</button>
                <a href="{{ route('admin.subcategories.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50">বাতিল</a>
            </div>
        </form>
    </div>
</div>
@endsection
