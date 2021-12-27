<?php

namespace App\Http\Requests\Moderators\Page;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePagesRequest extends FormRequest
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
            'content' => ['string', 'required'],
            'meta_title' => ['nullable', 'string', 'max:128'],
            'meta_h1' => ['nullable', 'string', 'max:128'],
            'meta_description' => ['nullable', 'string', 'max:512'],
            'meta_keywords' => ['nullable', 'string', 'max:512'],
            'instagram.*' => ['nullable', 'mimes:jpg,png,jpeg,svg', 'max:5120'],
            'banner_upload' => ['nullable', 'mimes:jpg,png,jpeg,svg', 'max:5120'],
            'contentImage1' => ['nullable', 'mimes:jpg,png,jpeg,svg', 'max:5120'],
            'contentImage2' => ['nullable', 'mimes:jpg,png,jpeg,svg', 'max:5120'],
            'lineImage' => ['nullable', 'mimes:jpg,png,jpeg,svg', 'max:5120'],
            'lineMedia' => ['nullable', 'mimes:jpg,png,jpeg,svg,mp4,flv,webm,avi', 'max:5120'],
            'deleted_files' => ['array', 'nullable'],
        ];
    }
}
