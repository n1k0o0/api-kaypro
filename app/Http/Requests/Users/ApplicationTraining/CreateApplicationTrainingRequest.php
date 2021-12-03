<?php

namespace App\Http\Requests\Users\ApplicationTraining;

use Illuminate\Foundation\Http\FormRequest;

class CreateApplicationTrainingRequest extends FormRequest
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
                'user_name' => ['required', 'string', 'max:512'],
                'phone' => ['required', 'string', 'max:20'],
                'email' => ['required', 'email'],
                'message' => ['nullable', 'string', 'max:2048'],
        ];
    }
}
