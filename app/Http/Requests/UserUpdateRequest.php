<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UserUpdateRequest extends UserStoreRequest
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

        $rules['email'] = [
            'prohibited'
        ];

        return $rules;
    }
}
