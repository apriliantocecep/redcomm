<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'brand_id' => [
                'required',
                'exists:App\Models\Brand,id'
            ],
            'name' => [
                'required',
                'min:3'
            ],
            'description' => [
                'required',
                'min:3'
            ],
            'year' => [
                'nullable',
                'digits:4',
                'integer',
                'min:1990',
            ],
            'color' => [
                'nullable'
            ],
            'photos' => [
                'required',
            ],
            'photos.*' => [
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ],
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $content = [
            'error' => true,
            'data' => [
                'message' => $validator->errors()->first(),
            ]
        ];

        $response = new \Illuminate\Http\Response($content, 422);
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
