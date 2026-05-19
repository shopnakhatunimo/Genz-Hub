@extends('layouts.admin.app')

@section('title', 'নতুন পণ্য')
@section('header', 'নতুন পণ্য যোগ করুন')

@section('content')
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="space-y-6">
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-bold mb-4">মূল তথ্য</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">ক্যাটাগরি *</label>
                        <select name="category_id" id="categorySelect" required class="input-field">
                            <option value="">ক্যাটাগরি নির্বাচন করুন</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">সাবক্যাটাগরি</label>
                        <select name="subcategory_id" id="subcategorySelect" class="input-field">
                            <option value="">প্রথমে ক্যাটাগরি নির্বাচন করুন</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">পণ্যের নাম *</label>
                        <input type="text" name="name" required class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">SKU</label>
                        <input type="text" name="sku" class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">ব্র্যান্ড</label>
                        <input type="text" name="brand" class="input-field">
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-bold mb-4">দাম ও স্টক</h2>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">দাম *</label>
                            <input type="number" name="price" step="0.01" required class="input-field">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">ডিসকাউন্ট দাম</label>
                            <input type="number" name="discount_price" step="0.01" class="input-field">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">স্টক *</label>
                        <input type="number" name="stock" required class="input-field">
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
                        <textarea name="short_description" rows="2" class="input-field"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">পূর্ণ বিবরণ</label>
                        <textarea name="description" rows="6" class="input-field"></textarea>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-bold mb-4">ছবি</h2>
                <div>
                    <label class="block text-sm font-medium mb-2">পণ্যের ছবি *</label>
                    <input type="file" name="images[]" multiple accept="image/*" required class="input-field">
                </div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-bold mb-4">সেটিংস</h2>
                <div class="space-y-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1" class="mr-2">
                        <span>ফিচারড পণ্য</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_trending" value="1" class="mr-2">
                        <span>ট্রেন্ডিং</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_flash_sale" value="1" class="mr-2">
                        <span>ফ্ল্যাশ সেল</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="status" value="1" checked class="mr-2">
                        <span>সক্রিয়</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-6">
        <button type="submit" class="btn-primary">পণ্য সংরক্ষণ করুন</button>
        <a href="{{ route('admin.products.index') }}" class="btn-outline ml-4">বাতিল</a>
    </div>
</form>

@push('scripts')
<script>
document.getElementById('categorySelect').addEventListener('change', function() {
    const categoryId = this.value;
    const subcategorySelect = document.getElementById('subcategorySelect');
    
    if (categoryId) {
        fetch(`/admin/subcategories/by-category/${categoryId}`)
            .then(response => response.json())
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
</script>
@endpush
@endsection
