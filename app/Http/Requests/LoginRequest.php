<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username'  => 'required|min:3|max:50',
            'password'  => 'required|min:8|max:50',
        ];
    }
}
