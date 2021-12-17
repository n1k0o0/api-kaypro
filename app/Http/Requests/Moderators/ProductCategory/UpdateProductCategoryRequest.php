<?php

namespace App\Http\Requests\Moderators\ProductCategory;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductCategoryRequest extends FormRequest
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
            'short_description' => ['nullable', 'string', 'max:512'],
            'full_description' => ['nullable', 'string', 'max:2048'],
            'composition' => ['nullable', 'string', 'max:2048'],
            'volume' => ['nullable', 'string', 'max:256'],
            'country' => ['nullable', 'string', 'max:256'],
            'status' => ['filled', 'string', 'max:256', Rule::in(Product::STATUSES)],
            'logo_upload' => ['nullable', 'mimes:jpg,png,jpeg,svg', 'max:5120'],
            'video_upload' => ['nullable', 'mimes:mp4,flv,webm,avi', 'max:20480'],
            'meta_title' => ['nullable', 'string', 'max:128'],
            'meta_description' => ['nullable', 'string', 'max:512'],
            'meta_keywords' => ['nullable', 'string', 'max:512'],
            'meta_image' => ['nullable', 'string', 'max:512'],
        ];
    }
}
