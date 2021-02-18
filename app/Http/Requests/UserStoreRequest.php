<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UserStoreRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'string',
                'max:64',
                'email:filter',
                Rule::unique('users')
            ],
            'password' => [
                'required',
                'string',
                'min:6'
            ],
            'name' => [
                'required',
                'string',
                'max:50'
            ],
            'phone' => [
                'sometimes',
                'string',
                'max:50'
            ]
        ];
    }
}
