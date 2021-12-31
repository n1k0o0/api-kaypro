<?php

namespace App\Http\Requests\Moderators\Slider;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSliderRequest extends FormRequest
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
            'title' => ['nullable', 'string', 'max:512'],
            'subtitle' => ['nullable', 'string', 'max:1024'],
            'link' => ['required', 'url', 'max:1024'],
            'button_text' => ['nullable', 'string', 'max:128'],
            'image_upload' => ['filled', 'mimes:jpg,png,jpeg,svg', 'max:5120'],

            'model_type' => ['required', 'string'],
            'model_id' => ['required', 'integer'],
            'title_color' => ['nullable', 'string', 'max:10'],
            'subtitle_color' => ['nullable', 'string', 'max:10'],
            'button' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:1024'],
        ];
    }
}
