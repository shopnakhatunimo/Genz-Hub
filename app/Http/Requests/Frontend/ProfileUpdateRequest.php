<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'name'   => 'required|string|max:255',
            'phone'  => 'nullable|string|max:20',
            'email'  => 'required|email|unique:users,email,' . Auth::id(),
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'নাম অবশ্যই প্রদান করতে হবে।',
            'email.required' => 'ইমেইল অবশ্যই প্রদান করতে হবে।',
            'email.unique'   => 'এই ইমেইল ইতোমধ্যে ব্যবহার হচ্ছে।',
            'avatar.image'   => 'ছবি ফাইল আপলোড করুন।',
            'avatar.max'     => 'ছবির সাইজ সর্বোচ্চ ২MB হতে পারবে।',
        ];
    }
}
