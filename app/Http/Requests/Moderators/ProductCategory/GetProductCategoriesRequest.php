<?php

namespace App\Http\Requests\Moderators\ProductCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'page' => ['nullable', 'integer'],
            'limit' => ['nullable', 'integer'],
            'title' => ['nullable', 'string', 'max:150'],
            'sort' => ['nullable', 'string', 'max:50'],
            'sort_type' => ['nullable', 'string', Rule::in(['asc', 'desc'])],
        ];
    }
}
