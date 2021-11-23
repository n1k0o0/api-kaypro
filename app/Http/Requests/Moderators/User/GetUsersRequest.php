<?php

namespace App\Http\Requests\Moderators\User;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\Pure;

class GetUsersRequest extends FormRequest
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

    #[Pure] public function rules(): array
    {
        return [
                'page' => ['nullable', 'integer'],
                'limit' => ['nullable', 'integer'],
                'sort' => ['nullable', 'string'],
                'sort_type' => ['nullable', 'string'],
                'last_name' => ['nullable', 'string', 'max:50'],
                'first_name' => ['nullable', 'string', 'max:50'],
                'phone' => ['nullable', 'string'],
                'email' => ['nullable', 'string'],
                'entity_name' => ['nullable', 'string', 'max:500'],
                'itn' => [
                        'nullable',
                        'integer',
                ],
                'psrn' => [
                        'nullable',
                        'integer'
                ],
                'entity_address' => ['nullable', 'string', 'max:500'],
        ];
    }
}
