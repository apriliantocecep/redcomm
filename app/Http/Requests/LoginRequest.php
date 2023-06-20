<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            //
            'email' => 'required|email',
            'password' => 'required|string|min:6',
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
