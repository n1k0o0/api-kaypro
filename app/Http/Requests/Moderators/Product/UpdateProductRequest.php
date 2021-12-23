<?php

namespace App\Http\Requests\Moderators\Product;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @property string deleted_files
 */
class UpdateProductRequest extends FormRequest
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
            'characteristic' => ['nullable', 'string', 'max:512'],
            'full_description' => ['nullable', 'string', 'max:2048'],
            'composition' => ['nullable', 'string', 'max:2048'],
            'volume' => ['nullable', 'string', 'max:256'],
            'dimension' => ['nullable', 'string', 'max:128'],
            'country' => ['nullable', 'string', 'max:256'],
            'status' => ['filled', 'boolean'],
            'deleted_files' => ['array', 'nullable'],
            'logo_upload' => ['array', 'nullable'],
            'logo_upload.*' => ['nullable', 'mimes:jpg,png,jpeg,svg', 'max:5120'],
            'video_upload' => ['nullable', 'mimes:mp4,flv,webm,avi', 'max:20480'],
            'meta_title' => ['nullable', 'string', 'max:128'],
            'meta_description' => ['nullable', 'string', 'max:512'],
            'meta_keywords' => ['nullable', 'string', 'max:512'],
            'meta_image' => ['nullable', 'string', 'max:512'],
        ];
    }

    /**
     * @throws \JsonException
     */
    public function prepareForValidation(): void
    {
        $this->merge([
            'deleted_files' => explode(',', $this->deleted_files)
        ]);
    }
}
