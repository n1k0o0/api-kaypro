<?php

namespace App\Http\Requests\Users\Auth;

use App\Rules\FixedLength;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
                'phone' => ['required', 'string', 'unique:users'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'string', 'min:6'],

                'entity' => ['required', 'boolean'],
                'entity_name' => ['required_if:entity,1', 'exclude_if:entity,0', 'string', 'max:500'],
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
