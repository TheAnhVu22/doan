<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CategoryProductUpdateRequest extends CategoryProductStoreRequest
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
            Rule::unique('category_products')->ignore($this->categoryProduct),
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'Tên danh mục'
        ];
    }
}
