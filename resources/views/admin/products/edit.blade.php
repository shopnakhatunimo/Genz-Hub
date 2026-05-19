@extends('layouts.admin.app')

@section('title', 'পণ্য সম্পাদনা')
@section('header', 'পণ্য সম্পাদনা')

@section('content')
<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="space-y-6">
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-bold mb-4">মূল তথ্য</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">পণ্যের নাম *</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="input-field">
                        @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">ক্যাটাগরি *</label>
                        <select name="category_id" id="categorySelect" required class="input-field">
                            <option value="">ক্যাটাগরি নির্বাচন করুন</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">সাবক্যাটাগরি</label>
                        <select name="subcategory_id" id="subcategorySelect" class="input-field">
                            <option value="">প্রথমে ক্যাটাগরি নির্বাচন করুন</option>
                            @foreach($subcategories as $sub)
                            <option value="{{ $sub->id }}" {{ $product->subcategory_id == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">SKU</label>
                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">ব্র্যান্ড</label>
                            <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" class="input-field">
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-bold mb-4">দাম ও স্টক</h2>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">দাম (৳) *</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" required class="input-field">
                            @error('price')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">ডিসকাউন্ট দাম (৳)</label>
                            <input type="number" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" step="0.01" class="input-field">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">স্টক *</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required class="input-field">
                        @error('stock')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="space-y-6">
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-bold mb-4">বিবরণ</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">ছোট বিবরণ</label>
                        <textarea name="short_description" rows="2" class="input-field">{{ old('short_description', $product->short_description) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">পূর্ণ বিবরণ</label>
                        <textarea name="description" rows="6" class="input-field">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-bold mb-4">বিদ্যমান ছবিসমূহ</h2>
                <div class="grid grid-cols-3 gap-3 mb-4">
                    @foreach($product->images as $image)
                    <div class="relative">
                        <img src="{{ asset('uploads/products/' . $image->image) }}" alt="Product" class="w-full h-20 object-cover rounded">
                        @if($image->is_primary)
                        <span class="absolute top-1 left-1 text-xs bg-green-500 text-white px-1 rounded">প্রধান</span>
                        @endif
                        <button type="button" onclick="deleteImage({{ $image->id }}, this)" class="absolute top-1 right-1 text-xs bg-red-500 text-white px-1 rounded">×</button>
                    </div>
                    @endforeach
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">নতুন ছবি যোগ করুন</label>
                    <input type="file" name="images[]" multiple accept="image/*" class="input-field">
                </div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-bold mb-4">সেটিংস</h2>
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="mr-2">
                        <span>ফিচারড পণ্য</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_trending" value="1" {{ $product->is_trending ? 'checked' : '' }} class="mr-2">
                        <span>ট্রেন্ডিং</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_flash_sale" value="1" {{ $product->is_flash_sale ? 'checked' : '' }} class="mr-2">
                        <span>ফ্ল্যাশ সেল</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="status" value="1" {{ $product->status ? 'checked' : '' }} class="mr-2">
                        <span>সক্রিয়</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-6 flex space-x-3">
        <button type="submit" class="btn-primary">আপডেট করুন</button>
        <a href="{{ route('admin.products.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50">বাতিল</a>
    </div>
</form>

@push('scripts')
<script>
document.getElementById('categorySelect').addEventListener('change', function() {
    const categoryId = this.value;
    const subcategorySelect = document.getElementById('subcategorySelect');
    if (categoryId) {
        fetch(`/admin/subcategories/by-category/${categoryId}`)
            .then(r => r.json())
            .then(data => {
                subcategorySelect.innerHTML = '<option value="">সাবক্যাটাগরি নির্বাচন করুন</option>';
                data.forEach(sub => {
                    subcategorySelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
                });
            });
    } else {
        subcategorySelect.innerHTML = '<option value="">প্রথমে ক্যাটাগরি নির্বাচন করুন</option>';
    }
});

function deleteImage(id, btn) {
    if (!confirm('ছবিটি মুছে ফেলবেন?')) return;
    fetch(`/admin/products/images/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
        .then(r => r.json())
        .then(() => btn.closest('.relative').remove())
        .catch(() => alert('ছবি মুছতে সমস্যা হয়েছে'));
}
</script>
@endpush
@endsection
