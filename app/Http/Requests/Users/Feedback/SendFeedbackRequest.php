<?php

namespace App\Http\Requests\Users\Feedback;

use App\Models\Page;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 *
 * @property string type
 *
 * */
class SendFeedbackRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:128'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'max:128'],
            'comment' => ['required', 'string', 'max:1024'],
            'agreement' => ['required', 'accepted'],
            'type' => ['required', 'string', Rule::in(Page::FEEDBACK_TYPES)],
        ];
    }
}
