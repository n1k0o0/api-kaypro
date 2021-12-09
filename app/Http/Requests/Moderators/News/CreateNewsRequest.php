<?php

namespace App\Http\Requests\Moderators\News;

use Illuminate\Foundation\Http\FormRequest;

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
    public function rules(): array
    {
        return [
            'title' => ['required', 'max:250'],
            'published_at' => ['required', 'date'],
            'text' => ['required', 'string', 'max:4096'],
            'visibility' => ['required', 'boolean'],
            'logo_upload' => ['required', 'mimes:jpg,png,jpeg,svg', 'max:5120'],
            'meta_title' => ['nullable', 'string', 'max:128'],
            'meta_description' => ['nullable', 'string', 'max:512'],
            'meta_keywords' => ['nullable', 'string', 'max:512'],
            'meta_slug' => ['nullable', 'string', 'max:128'],
            'meta_image' => ['nullable', 'string', 'max:512'],
        ];
    }
}
