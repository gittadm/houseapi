<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CartProductDeleteRequest extends BaseFormRequest
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
                'sometimes',
                'integer',
                Rule::exists('products', 'id')
            ],
        ];
    }
}
