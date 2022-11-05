<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'content' => 'required|string|max:1000',
            'product_id' => 'required|exists:products,id',
            'comment_parent_id' => 'required|exists:comments,id',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên nhân viên',
            'content' => 'Nội dung phản hồi',
            'product_id' => 'Sản phẩm',
            'comment_parent_id' => 'Bình luận',
        ];
    }
}
