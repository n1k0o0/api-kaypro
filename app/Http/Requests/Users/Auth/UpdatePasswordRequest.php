<?php

namespace App\Http\Requests\Users\Auth;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class UpdatePasswordRequest extends FormRequest
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
    #[ArrayShape(['code' => "string[]", 'new_password' => "string[]"])] public function rules(): array
    {
        return [
                'code' => [
                        'required',
                        'digits:4',
                ],
                'new_password' => [
                        'required',
                        'string',
                        'min:6',
                        'max:255'
                ],
        ];
    }
}
