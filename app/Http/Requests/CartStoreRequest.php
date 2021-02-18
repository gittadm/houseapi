<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CartStoreRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'products' => [
                'required',
                'array',
                'min:1'
            ],
            'products.*.id' => [
                'required',
                'integer',
                Rule::exists('products', 'id')
            ],
            'products.*.count' => [
                'required',
                'integer',
                'min:0',
                'max:100000'
            ],
        ];
    }
}
