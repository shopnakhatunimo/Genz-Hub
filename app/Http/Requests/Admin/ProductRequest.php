<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product') ? $this->route('product')->id : null;

        return [
            'name'           => 'required|string|max:255',
            'slug'           => 'required|string|max:255|unique:products,slug,' . $productId,
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'sale_price'     => 'nullable|numeric|min:0|lt:price',
            'stock'          => 'required|integer|min:0',
            'sku'            => 'nullable|string|max:100',
            'status'         => 'required|in:active,inactive',
            'is_featured'    => 'nullable|boolean',
            'images.*'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'পণ্যের নাম অবশ্যই প্রদান করতে হবে।',
            'slug.required'        => 'স্লাগ অবশ্যই প্রদান করতে হবে।',
            'slug.unique'          => 'এই স্লাগ ইতোমধ্যে ব্যবহার হচ্ছে।',
            'category_id.required' => 'ক্যাটাগরি নির্বাচন করুন।',
            'price.required'       => 'মূল্য অবশ্যই প্রদান করতে হবে।',
            'sale_price.lt'        => 'বিক্রয় মূল্য নিয়মিত মূল্যের চেয়ে কম হতে হবে।',
            'stock.required'       => 'স্টক পরিমাণ প্রদান করুন।',
            'status.required'      => 'স্ট্যাটাস নির্বাচন করুন।',
            'images.*.image'       => 'ছবি ফাইল আপলোড করুন।',
            'images.*.max'         => 'প্রতিটি ছবির সাইজ সর্বোচ্চ ৩MB।',
        ];
    }
}
