<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => 'required|email',
            'password' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'ইমেইল অবশ্যই প্রদান করতে হবে।',
            'email.email'       => 'সঠিক ইমেইল ঠিকানা প্রদান করুন।',
            'password.required' => 'পাসওয়ার্ড অবশ্যই প্রদান করতে হবে।',
        ];
    }
}
