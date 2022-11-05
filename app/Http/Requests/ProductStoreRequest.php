<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:200|unique:products',
            'description' => 'nullable',
            'price' => 'required|integer|gt:0|max:1000000000',
            'discount' => 'nullable|integer|gt:0|max:100',
            'quantity' => 'required|integer|gt:0|max:1000000000',
            'tag_id' => 'nullable|array',
            'tag_id.*' => 'exists:tags,id',
            'category_id' => 'required|exists:category_products,id',
            'brand_id' => 'required|exists:brand_products,id',
            'image' => 'nullable|image',
            'is_active' => 'nullable|in:1,2'
        ];
    }

    function attributes()
    {
        return [
            'name' => 'Tên sản phẩm',
            'description' => 'Thông tin sản phẩm',
            'discount' => 'Giảm giá'
        ];
    }
}
