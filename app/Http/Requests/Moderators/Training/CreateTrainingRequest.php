<?php

namespace App\Http\Requests\Moderators\Training;

use App\Models\Training;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTrainingRequest extends FormRequest
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
                'name' => ['required', 'string', 'max:150'],
                'description' => ['required', 'string', 'max:4096'],
                'city' => ['required', 'string', 'max:100'],
                'location' => ['required', 'string', 'max:100'],
                'date' => ['required', 'date', 'max:100'],
                'duration' => ['required', 'string', 'max:200'],
                'price' => ['required', 'string', 'max:100'],
                'lecturer' => ['required', 'string', 'max:150'],
                'lecturer_position' => ['required', 'string', 'max:250'],
                'lecturer_description' => ['nullable', 'string', 'max:500'],
                'days' => ['nullable', 'array'],
                'status' => ['required', 'string', Rule::in(Training::STATUSES)],
                'seats' => ['required', 'integer', 'max:99999'],
                'is_visible' => ['required', 'boolean'],
                'logo_upload' => ['required', 'mimes:jpg,png,jpeg,svg', 'max:5120'],
                'lecturer_avatar_upload' => ['nullable', 'mimes:jpg,png,jpeg,svg', 'max:5120'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     * @throws \JsonException
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
                'days' => json_decode($this->days, true, 512, JSON_THROW_ON_ERROR),
        ]);
    }
}
