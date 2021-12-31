<?php

namespace App\Http\Requests\Moderators\Slider;

use Illuminate\Foundation\Http\FormRequest;

class CreateSlideRequest extends FormRequest
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
            'model_type' => ['required', 'string'],
            'model_id' => ['required', 'integer'],
            'collection_name' => ['nullable', 'string', 'max:128'],
            'title' => ['nullable', 'string', 'max:255'],
            'title_color' => ['nullable', 'string', 'max:10'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'subtitle_color' => ['nullable', 'string', 'max:10'],
            'link' => ['nullable', 'string', 'max:255'],
            'button' => ['nullable', 'boolean'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1024'],
            'image_upload' => ['required', 'mimes:jpg,png,jpeg,svg', 'max:5096'],
        ];
    }
}
