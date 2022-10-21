<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:200|unique:posts',
            'description' => 'nullable',
            'author_name' => 'required|max:255',
            'category_id' => 'required|exists:category_posts,id',
            'image' => 'nullable|image',
            'is_active' => 'nullable|in:1,2'
        ];
    }

    function attributes()
    {
        return [
            'name' => 'Tên bài viết',
            'description' => 'Nội dung bài viết'
        ];
    }
}
