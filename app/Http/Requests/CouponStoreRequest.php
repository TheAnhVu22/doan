<?php

namespace App\Http\Requests;

use App\Rules\CheckTypeDiscount;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class CouponStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'code' => 'required|unique:coupons|min:5|max:10',
            'quantity' => 'required|gt:0|integer',
            'type' => 'required|in:1,2',
            'value' => [
                'required',
                'gt:0',
                'integer',
                new CheckTypeDiscount($this->type)
            ],
            'start_date' => 'required|date|after_or_equal:' . Carbon::now()->format('Y-m-d'),
            'end_date' => 'required|date|after_or_equal:start_date',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên mã',
            'code' => 'Mã giảm giá',
            'type' => 'Kiểu giảm giá',
            'value' => 'Giá trị giảm'
        ];
    }
}
