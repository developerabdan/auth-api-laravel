<?php

namespace App\Http\Requests\Api;

use App\Http\Resources\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Email dibutuhkan',
            'email.email' => 'Email harus valid',
            'password.required' => 'Password dibutuhkan',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ApiResponse::error(collect($validator->errors())->flatten()->implode(' dan '), 422));
    }
}
