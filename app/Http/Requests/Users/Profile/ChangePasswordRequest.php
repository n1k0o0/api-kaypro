<?php

namespace App\Http\Requests\Users\Profile;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string password
 * @property string old_password
 */
class ChangePasswordRequest extends FormRequest
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
            'old_password' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', 'min:6'],
        ];
    }
}
