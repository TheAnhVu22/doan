<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class PostUpdateRequest extends PostStoreRequest
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
            Rule::unique('posts')->ignore($this->post),
        ];

        return $rules;
    }

    function attributes()
    {
        return [
            'name' => 'Tên bài viết',
            'description' => 'Nội dung bài viết'
        ];
    }
}
