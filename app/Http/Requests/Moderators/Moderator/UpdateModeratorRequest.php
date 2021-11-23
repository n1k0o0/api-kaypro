<?php

namespace App\Http\Requests\Moderators\Moderator;

use App\Models\Moderator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class UpdateModeratorRequest extends FormRequest
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
            'last_name' => "string[]",
            'first_name' => "string[]",
            'patronymic' => "string[]",
            'address' => "string[]",
            'type' => "array",
            'phone' => "array",
            'email' => "array"
    ])] public function rules(): array
    {
        return [
                'last_name' => ['required', 'string', 'max:50'],
                'first_name' => ['required', 'string', 'max:50'],
                'patronymic' => ['nullable', 'string', 'max:100'],
                'type' => ['required', 'string', Rule::in(Moderator::TYPES)],
                'phone' => [
                        'required',
                        'string',
                        Rule::unique(Moderator::class, 'phone')->ignoreModel($this->moderator)
                ],
                'email' => [
                        'required',
                        'email',
                        Rule::unique(Moderator::class, 'email')->ignoreModel($this->moderator)
                ],
        ];
    }
}
