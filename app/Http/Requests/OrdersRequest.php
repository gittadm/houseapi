<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class OrdersRequest extends BaseFormRequest
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
            'limit' => [
                'required',
                'integer',
                'min:0',
                'max:100000'
            ]
        ];
    }
}
