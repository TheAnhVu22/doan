<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlideStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'nullable|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg'
        ];
    }
}
