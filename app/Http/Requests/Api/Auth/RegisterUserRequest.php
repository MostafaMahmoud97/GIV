<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'country_id' => "required|integer|exists:countries,id",
            'name' => "required|min:3",
            'country_code' => "required|integer|exists:countries,phone_code",
            'phone' => "required|string|min:10",
            'email' => "required|email|unique:users,email",
            'password' => "required|min:8|confirmed",
        ];
    }
}
