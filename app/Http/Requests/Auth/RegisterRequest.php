<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'নাম অবশ্যই প্রদান করতে হবে।',
            'email.required'    => 'ইমেইল অবশ্যই প্রদান করতে হবে।',
            'email.email'       => 'সঠিক ইমেইল ঠিকানা প্রদান করুন।',
            'email.unique'      => 'এই ইমেইল ইতোমধ্যে নিবন্ধিত।',
            'password.required' => 'পাসওয়ার্ড অবশ্যই প্রদান করতে হবে।',
            'password.min'      => 'পাসওয়ার্ড কমপক্ষে ৮ অক্ষরের হতে হবে।',
            'password.confirmed'=> 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না।',
        ];
    }
}
