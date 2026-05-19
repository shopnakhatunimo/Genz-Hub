<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token'    => 'required',
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'token.required'    => 'টোকেন প্রয়োজন।',
            'email.required'    => 'ইমেইল অবশ্যই প্রদান করতে হবে।',
            'email.exists'      => 'এই ইমেইল দিয়ে কোনো অ্যাকাউন্ট পাওয়া যায়নি।',
            'password.required' => 'নতুন পাসওয়ার্ড অবশ্যই প্রদান করতে হবে।',
            'password.min'      => 'পাসওয়ার্ড কমপক্ষে ৮ অক্ষরের হতে হবে।',
            'password.confirmed'=> 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না।',
        ];
    }
}
