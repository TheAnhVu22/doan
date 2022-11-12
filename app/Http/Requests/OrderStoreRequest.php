<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'shipping_name' => 'required|string|min:3|max:50',
            'shipping_phone' => 'required|numeric|digits_between: 10,11',
            'note' => 'nullable|max:1000',
            'payment_method' => 'required|integer|in:1,2',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'ward_id' => 'required|exists:wards,id',
            'feeShip' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'shipping_phone.digits_between' => ':attribute phải từ 10 đến 11 số'
        ];
    }

    public function attributes()
    {
        return [
            'shipping_name' => 'Tên người mua',
            'shipping_phone' => 'Số điện thoại',
            'note' => 'Ghi chú',
            'payment_method' => 'Phương thức thanh toán',
            'city_id' => 'Thành phố/Tỉnh',
            'district_id' => 'Quận/Huyện',
            'ward_id' => 'Xã/Phường',
        ];
    }
}
