<?php

namespace App\Http\Requests\Admin\GiftBox;

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
            "box_name_en" => "required|string|min:3",
            "box_name_ar" => "required|string|min:3",
            "box_code" => "required|string",
            "price" => "required|numeric|not_in:0",
            "width" => "required|numeric|not_in:0",
            "height" => "required|numeric|not_in:0",
            "length" => "required|numeric|not_in:0",
            "media" => "required|array|min:1",
            "media.*" => "mimes:jpg,png,jpeg,svg",
        ];
    }
}
