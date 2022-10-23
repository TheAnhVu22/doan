<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class TagUpdateRequest extends TagStoreRequest
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
            Rule::unique('tags')->ignore($this->tag),
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'Tên tag'
        ];
    }
}
