<?php

namespace App\Http\Requests\Admin\Wrapping;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            "title_ar" => "required|string",
            "title_en" => "required|string",
            "code" => "required|string",
            "material" => "required|string",
            "price_egy" => "required|numeric|gt:0",
            "price_usd" => "required|numeric|gt:0",
            "media" => "array|min:1",
            "media.*" => "mimes:jpg,png,jpeg,svg",
        ];
    }
}
