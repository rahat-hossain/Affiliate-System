<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackagesValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'required',
            'discount_rule_id' => 'required',
            'tax_percentage' => 'required|numeric|min:0|max:99',
            'price' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'tax_percentage.max' => '% value must be less then 100',
            'tax_percentage.numeric' => 'value must be only number',
        ];
    }
}
