<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $bannerId = $this->route('banner') ? $this->route('banner')->id : null;

        return [
            'title'    => 'required|string|max:255',
            'image'    => $bannerId ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120' : 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'link'     => 'nullable|url|max:500',
            'type'     => 'required|in:hero,promotional',
            'sort'     => 'nullable|integer|min:0',
            'status'   => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'  => 'ব্যানারের শিরোনাম অবশ্যই প্রদান করতে হবে।',
            'image.required'  => 'ব্যানারের ছবি আপলোড করুন।',
            'image.max'       => 'ছবির সাইজ সর্বোচ্চ ৫MB।',
            'type.required'   => 'ব্যানারের ধরন নির্বাচন করুন।',
            'status.required' => 'স্ট্যাটাস নির্বাচন করুন।',
        ];
    }
}
