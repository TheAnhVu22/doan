<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:tags|max:100',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên tag'
        ];
    }
}