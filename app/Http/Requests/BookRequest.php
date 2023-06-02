<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
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
        if (request()->isMethod('PUT') || request()->isMethod('PATCH')) {
            
        }

        $rules = [
            // 'name' => 'required|string|unique:products|max:255',
            'name' => Rule::unique('students')->ignore($this->route()->parameter('student')),
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $product = $this->route()->parameter('product');

            $rules['name'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('loan_products')->ignore($product),
            ];
        }

        return $rules;
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Email is required!',
            'name.required' => 'Name is required!',
            'password.required' => 'Password is required!'
        ];
    }
}
