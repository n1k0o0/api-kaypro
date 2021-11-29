<?php

namespace App\Http\Requests\Moderators\ApplicationTraining;

use App\Models\ApplicationTraining;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class UpdateApplicationTrainingRequest extends FormRequest
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
            'user_id' => "array",
            'user_name' => "string[]",
            'email' => "string[]",
            'phone' => "string[]",
            'status' => "array"
    ])] public function rules(): array
    {
        return [
                'user_id' => ['nullable', 'integer', Rule::exists(User::class, 'id')],
                'user_name' => ['required', 'string', 'max:500'],
                'email' => ['required', 'email', 'max:100'],
                'phone' => ['required', 'string', 'max:20'],
                'status' => ['required', 'string', Rule::in(ApplicationTraining::STATUSES)],
        ];
    }
}
