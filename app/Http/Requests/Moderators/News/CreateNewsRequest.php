<?php

namespace App\Http\Requests\Moderators\News;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class CreateNewsRequest extends FormRequest
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
            'title' => "string[]",
            'published_at' => "string[]",
            'text' => "string[]",
            'visibility' => "string[]",
            'logo' => "string[]"
    ])] public function rules(): array
    {
        return [
                'title' => ['required', 'max:250'],
                'published_at' => ['required', 'date'],
                'text' => ['required', 'string', 'max:4096'],
                'visibility' => ['required', 'boolean'],
                'logo' => ['required', 'mimes:jpg,png,jpeg,svg', 'max:5120'],
        ];
    }
}
