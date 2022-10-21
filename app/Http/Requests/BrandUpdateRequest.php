<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class BrandUpdateRequest extends BrandStoreRequest
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
            'max:100',
            Rule::unique('brand_products')->ignore($this->brand),
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'Tên thương hiệu'
        ];
    }
}
