<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
            'shipping_address' => 'required|max:1000',
            'feeShip' => 'required|integer',
            'status' =>'required|in:1,2,3'
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
            'shipping_address' => 'Địa chỉ giao hàng',
            'status' => 'Trạng thái đơn hàng',
        ];
    }
}
