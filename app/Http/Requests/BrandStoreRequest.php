<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:brand_products|max:100',
            'description' => 'nullable|max:1000',
            'is_active' => 'nullable|in:1,2',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên thương hiệu'
        ];
    }
}