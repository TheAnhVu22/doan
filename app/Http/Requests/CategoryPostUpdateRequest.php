<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryPostUpdateRequest extends CategoryPostStoreRequest
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
            Rule::unique('category_posts')->ignore($this->categoryPost),
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
