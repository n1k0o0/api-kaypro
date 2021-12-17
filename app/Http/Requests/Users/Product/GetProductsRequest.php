<?php

namespace App\Http\Requests\Users\Product;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string name
 */
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
            'name' => ['nullable', 'string', 'max:512'],
        ];
    }
}
