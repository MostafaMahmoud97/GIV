<?php

namespace App\Http\Requests\Api\BusinessRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            "store_name" => "required|string",
            "no_branches" => "required|integer",
            "store_type" => "required|string",
            "store_address" => "required|string",
            "first_name" => "required|string",
            "last_name" => "required|string",
            "phone_number" => "required|string",
            "email" => "required|email",
            ""
        ];
    }
}
