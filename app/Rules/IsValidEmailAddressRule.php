<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsValidEmailAddressRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            $fail("The value must be a string");
        }


        if (
            preg_match_all("/^\S+@\S+\.\S+$/", $value) < 0
            || preg_match_all("/^\S+@\S+\.\S+$/", $value) == false
        ) {
            $fail("The value is not a valid email address");
        }
    }
}
