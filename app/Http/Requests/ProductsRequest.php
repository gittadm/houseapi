<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class ProductsRequest extends BaseFormRequest
{
    /**
     * Prepare the boolean data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'limit' => $this->limit ?? 50,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'min_price' => [
                'sometimes',
                'integer',
                'min:0'
            ],
            'max_price' => [
                'sometimes',
                'integer',
                'min:0'
            ],
            'width' => [
                'sometimes',
                'integer',
                'min:0',
                'max:1000'
            ],
            'height' => [
                'sometimes',
                'integer',
                'min:0',
                'max:1000'
            ],
            'category' => [
                'sometimes',
                'integer',
                Rule::exists('categories', 'id')
            ],
            'limit' => [
                'required',
                'integer',
                'min:0',
                'max:100000'
            ]
        ];
    }
}
