<?php

namespace App\Http\Requests\Moderators\Moderator;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class GetModeratorsRequest extends FormRequest
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
            'sort' => "string[]",
            'sort_type' => "string[]",
            'last_name' => "string[]",
            'first_name' => "string[]",
            'phone' => "string[]",
            'email' => "string[]"
    ])] public function rules(): array
    {
        return [
                'page' => ['nullable', 'integer'],
                'limit' => ['nullable', 'integer'],
                'sort' => ['nullable', 'string'],
                'sort_type' => ['nullable', 'string'],
                'last_name' => ['nullable', 'string', 'max:50'],
                'first_name' => ['nullable', 'string', 'max:50'],
                'phone' => ['nullable', 'string'],
                'email' => ['nullable', 'string'],
        ];
    }
}
