<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category') ? $this->route('category')->id : null;

        return [
            'name'   => 'required|string|max:255',
            'slug'   => 'required|string|max:255|unique:categories,slug,' . $categoryId,
            'image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'   => 'ক্যাটাগরির নাম অবশ্যই প্রদান করতে হবে।',
            'slug.required'   => 'স্লাগ অবশ্যই প্রদান করতে হবে।',
            'slug.unique'     => 'এই স্লাগ ইতোমধ্যে ব্যবহার হচ্ছে।',
            'status.required' => 'স্ট্যাটাস নির্বাচন করুন।',
        ];
    }
}
