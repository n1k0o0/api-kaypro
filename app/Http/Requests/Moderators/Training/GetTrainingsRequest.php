<?php

namespace App\Http\Requests\Moderators\Training;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class GetTrainingsRequest extends FormRequest
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
            'name' => "string[]",
            'date' => "string[]",
            'sort' => "string[]",
            'sort_type' => "string[]"
    ])] public function rules(): array
    {
        return [
                'page' => ['nullable', 'integer'],
                'limit' => ['nullable', 'integer'],
                'name' => ['nullable', 'string', 'max:512'],
                'date' => ['nullable', 'date'],
                'sort' => ['nullable', 'string', 'max:50'],
                'sort_type' => ['nullable', 'string', Rule::in(['asc', 'desc'])],
        ];
    }
}
