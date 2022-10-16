<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:8|max:255',
            'phone' => 'required|numeric|digits_between: 10,11',
            'status' => 'nullable|in:1,2',
            'provider_id' => 'nullable|max:255'
        ];
    }
}
