<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $couponId = $this->route('coupon') ? $this->route('coupon')->id : null;

        return [
            'code'           => 'required|string|max:50|unique:coupons,code,' . $couponId,
            'type'           => 'required|in:percentage,fixed',
            'value'          => 'required|numeric|min:1',
            'min_amount'     => 'nullable|numeric|min:0',
            'max_uses'       => 'nullable|integer|min:1',
            'expires_at'     => 'nullable|date|after:today',
            'status'         => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required'   => 'কুপন কোড অবশ্যই প্রদান করতে হবে।',
            'code.unique'     => 'এই কুপন কোড ইতোমধ্যে বিদ্যমান।',
            'type.required'   => 'ছাড়ের ধরন নির্বাচন করুন।',
            'value.required'  => 'ছাড়ের মান প্রদান করুন।',
            'expires_at.after'=> 'মেয়াদ শেষের তারিখ ভবিষ্যতে হতে হবে।',
            'status.required' => 'স্ট্যাটাস নির্বাচন করুন।',
        ];
    }
}
