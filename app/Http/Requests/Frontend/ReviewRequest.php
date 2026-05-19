<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'required|string|min:5|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'পণ্য নির্বাচন করুন।',
            'product_id.exists'   => 'পণ্যটি পাওয়া যায়নি।',
            'rating.required'     => 'রেটিং দিন।',
            'rating.min'          => 'রেটিং কমপক্ষে ১ হতে হবে।',
            'rating.max'          => 'রেটিং সর্বোচ্চ ৫ হতে পারবে।',
            'comment.required'    => 'মন্তব্য অবশ্যই লিখতে হবে।',
            'comment.min'         => 'মন্তব্য কমপক্ষে ৫ অক্ষরের হতে হবে।',
        ];
    }
}
