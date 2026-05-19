<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'ইমেইল অবশ্যই প্রদান করতে হবে।',
            'email.email'    => 'সঠিক ইমেইল ঠিকানা প্রদান করুন।',
            'email.exists'   => 'এই ইমেইল দিয়ে কোনো অ্যাকাউন্ট পাওয়া যায়নি।',
        ];
    }
}
