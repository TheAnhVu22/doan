<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class ProductUpdateRequest extends ProductStoreRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = parent::rules();

        $rules['name'] = [
            'required',
            'max:200',
            Rule::unique('products')->ignore($this->product),
        ];

        return $rules;
    }

    function attributes()
    {
        return [
            'name' => 'Tên sản phẩm',
            'description' => 'Thông tin sản phẩm'
        ];
    }
}
