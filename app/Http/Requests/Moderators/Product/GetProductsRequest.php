<?php

namespace App\Http\Requests\Moderators\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetProductsRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:512'],
            'vendor_code' => ['nullable', 'string', 'max:512'],
            'sort' => ['nullable', 'string', 'max:50'],
            'sort_type' => ['nullable', 'string', Rule::in(['asc', 'desc'])],
        ];
    }
}
