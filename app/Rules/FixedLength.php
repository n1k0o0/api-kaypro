<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FixedLength implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(public array $lengths)
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return in_array(strlen((string)$value), $this->lengths, true);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Длина :attribute должна быть - '.implode(',', $this->lengths);
    }
}
