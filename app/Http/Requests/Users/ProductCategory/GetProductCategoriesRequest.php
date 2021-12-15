<?php

namespace App\Http\Requests\Users\ProductCategory;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string title
 */
class GetProductCategoriesRequest extends FormRequest
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
            'title' => ['nullable', 'string', 'max:512']
        ];
    }
}
