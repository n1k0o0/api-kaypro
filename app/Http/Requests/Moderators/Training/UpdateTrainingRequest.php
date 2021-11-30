<?php

namespace App\Http\Requests\Moderators\Training;

use App\Models\Training;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTrainingRequest extends FormRequest
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
                'location' => ['required', 'string', 'max:100'],
                'date' => ['required', 'date', 'max:100'],
                'duration' => ['required', 'string', 'max:200'],
                'price' => ['required', 'string', 'max:100'],
                'lecturer' => ['required', 'string', 'max:150'],
                'status' => ['required', 'string', Rule::in(Training::STATUSES)],
                'seats' => ['required', 'integer', 'max:99999'],
                'empty_seats' => ['required', 'integer', 'max:99999', 'lte:seats'],
                'is_visible' => ['required', 'boolean'],
                'logo' => ['filled', 'mimes:jpg,png,jpeg,svg', 'max:5120'],
        ];
    }
}
