<?php

namespace App\Http\Requests\Moderators\News;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class GetNewsRequest extends FormRequest
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
    #[ArrayShape([
            'page' => "string[]",
            'limit' => "string[]",
            'title' => "string[]",
            'published_at' => "string[]",
            'sort' => "string[]",
            'sort_type' => "array"
    ])] public function rules(): array
    {
        return [
                'page' => ['nullable', 'integer'],
                'limit' => ['nullable', 'integer'],
                'title' => ['nullable', 'string', 'max:150'],
                'published_at' => ['nullable', 'date'],
                'sort' => ['nullable', 'string', 'max:50'],
                'sort_type' => ['nullable', 'string', Rule::in(['asc', 'desc'])],
        ];
    }
}
