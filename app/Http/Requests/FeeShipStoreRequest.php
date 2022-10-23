<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeeShipStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'ward_id' => 'required|exists:wards,id',
            'fee_ship' => 'required|numeric|gt:0'
        ];
    }

    public function attributes()
    {
        return [
            'city_id' => 'Tỉnh/Thành phố',
            'district_id' => 'Quận/Huyện',
            'ward_id' => 'Xã/Phường',
            'fee_ship' => 'Phí vận chuyển',
        ];
    }
}
