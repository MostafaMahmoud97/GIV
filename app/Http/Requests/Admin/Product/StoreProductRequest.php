<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            "code" => "required|unique:products,code",
            "description_ar" => "required|string",
            "description_en" => "required|string",
            "main_price_egy" => "required|numeric",
            "main_instead_of_egy" => "required|numeric",
            "main_price_usd" => "required|numeric",
            "main_instead_of_usd" => "required|numeric",
            "category_ids" => "required|array|min:1",
            "category_ids.*" => "required|integer|exists:categories,id",
            "attribute_ids" => "required|array|min:1|max:3",
            "attribute_ids.*" => "required|integer|exists:attributes,id",
            "variations" => "required|array|min:1",
            "variations.*.value_one_id" => "required|integer|exists:values,id",
            "variations.*.value_two_id" => "required|integer|gt:-1",
            "variations.*.value_three_id" => "required|integer|gt:-1",
            "variations.*.base_price_egy" => "required|numeric",
            "variations.*.price_instead_of_egy" => "required|numeric",
            "variations.*.base_price_usd" => "required|numeric",
            "variations.*.price_instead_of_usd" => "required|numeric",
            "variations.*.available" => "required|numeric",
        ];
    }
}
