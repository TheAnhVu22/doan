<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|unique:admins|min:3|max:50',
            'email' => 'required|email|unique:admins|max:255',
            'password' => 'required|confirmed|min:8|max:50',
            'birthday' => 'required|date|before_or_equal:' . \Carbon\Carbon::now()->format('Y-m-d'),
            'phone' => 'required|numeric|digits_between: 10,11',
            'role_id' => 'required|exists:roles,id',
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height:100,max_width:1000,max_height:1000',
            'is_active' => 'nullable|in:1,2'
        ];
    }
}
