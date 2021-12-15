<?php

namespace App\Http\Requests\Moderators\ProductCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'subtitle' => ['filled', 'string', 'max:512'],
            'order' => ['nullable', 'integer', 'min:0'],
            'logo_upload' => ['filled', 'mimes:jpg,png,jpeg,svg', 'max:5120'],
            'banner_upload' => ['filled', 'mimes:jpg,png,jpeg,svg', 'max:5120'],
        ];
    }
}
