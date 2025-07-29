<?php

namespace App\Http\Requests\Api;

use App\Http\Resources\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:255',
            'name' => 'required|string|max:255',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Email dibutuhkan',
            'email.email' => 'Email harus valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password dibutuhkan',
            'password.string' => 'Password harus string',
            'password.min' => 'Password minimal 8 karakter',
            'password.max' => 'Password maksimal 255 karakter',
            'name.required' => 'Nama dibutuhkan',
            'name.string' => 'Nama harus string',
            'name.max' => 'Nama maksimal 255 karakter',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ApiResponse::error(collect($validator->errors())->flatten()->implode(' dan '), 422));
    }
}
