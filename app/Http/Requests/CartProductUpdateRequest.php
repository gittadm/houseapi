<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CartProductUpdateRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => [
                'required',
                'integer',
                Rule::exists('products', 'id')
            ],
            'count' => [
                'required',
                'integer',
                'min:0',
                'max:100000'
            ],
        ];
    }
}
