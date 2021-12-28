<?php

namespace App\Http\Requests\Moderators\User;

use App\Models\User;
use App\Rules\FixedLength;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'last_name' => ['required', 'string', 'max:50'],
            'first_name' => ['required', 'string', 'max:50'],
            'patronymic' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:500'],
            'subscribe' => ['required', 'boolean'],
            'phone' => ['required', 'string', Rule::unique(User::class, 'phone')->ignoreModel($this->user)],
            'email' => ['required', 'email', Rule::unique(User::class, 'email')->ignoreModel($this->user)],
            'status' => [
                'required',
                'string',
                Rule::in(User::STATUSES)
            ],
            'entity' => ['required', 'boolean'],
            'entity_name' => ['required_if:entity,1', 'exclude_if:entity,0', 'string', 'max:500'],
            'entity_status' => [
                'required_if:entity,1',
                'exclude_if:entity,0',
                'string',
                Rule::in(User::ENTITY_STATUSES)
            ],
            'itn' => [
                'required_if:entity,1',
                'exclude_if:entity,0',
                'integer',
                new FixedLength([10, 13]),
                Rule::unique('users', 'itn')
                    ->where('psrn', $this->psrn)
                    ->ignore($this->user)
            ],
            'psrn' => [
                'required_if:entity,1',
                'exclude_if:entity,0',
                'digits:13',
                Rule::unique('users', 'psrn')
                    ->where('itn', $this->itn)
                    ->ignore($this->user)
            ],
            'entity_address' => ['nullable', 'exclude_if:entity,0', 'string', 'max:500'],
        ];
    }
}
