<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CepValidation implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (bool) preg_match('/^[0-9]{5,5}([- ]?[0-9]{3,3})?$/', trim($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.cepInvalido');
    }
}
