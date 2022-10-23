<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CouponUpdateRequest extends CouponStoreRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = parent::rules();

        $rules['code'] = [
            'required',
            'min:5',
            'max:10',
            Rule::unique('coupons')->ignore($this->coupon),
        ];

        return $rules;
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
