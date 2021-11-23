<?php

namespace App\Http\Requests\Users\Auth;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class VerifyEmailRequest extends FormRequest
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
    #[ArrayShape(['email' => "string[]", 'code' => "string[]"])] public function rules(): array
    {
        return [
                'email' => [
                        'required',
                        'string',
                        'email:filter'
                ],
                'code' => [
                        'required',
                        'digits:4',
                ]
        ];
    }
}
