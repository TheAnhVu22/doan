<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class AdminUpdateRequest extends AdminStoreRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = parent::rules();

        if (!$this['password']) {
            unset($rules['password']);
        }

        $rules['username'] = [
            'required',
            'min:3',
            'max:50',
            Rule::unique('admins')->ignore($this->admin),
        ];

        $rules['email'] = [
            'required',
            'max:255',
            'email',
            Rule::unique('admins')->ignore($this->admin),
        ];

        return $rules;
    }
}
