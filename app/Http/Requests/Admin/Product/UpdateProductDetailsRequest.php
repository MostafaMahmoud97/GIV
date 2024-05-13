<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductDetailsRequest extends FormRequest
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
            "title_en" => "required|string",
            "title_ar" => "required|string",
            "code" => "required|unique:products,code,".$this->id,
            "description_ar" => "required|string",
            "description_en" => "required|string",
            "category_ids" => "required|array|min:1",
            "category_ids.*" => "required|integer|exists:categories,id",
        ];
    }
}
