<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'address_line' => 'required|string|max:500',
            'city'         => 'required|string|max:100',
            'district'     => 'required|string|max:100',
            'postal_code'  => 'nullable|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'নাম অবশ্যই প্রদান করতে হবে।',
            'phone.required'        => 'ফোন নম্বর অবশ্যই প্রদান করতে হবে।',
            'address_line.required' => 'ঠিকানা অবশ্যই প্রদান করতে হবে।',
            'city.required'         => 'শহর অবশ্যই প্রদান করতে হবে।',
            'district.required'     => 'জেলা অবশ্যই প্রদান করতে হবে।',
        ];
    }
}
