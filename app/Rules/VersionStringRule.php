<?php

namespace App\Rules;

use App\Utils\VersionUtil;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class VersionStringRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (VersionUtil::isValid($value)) {
            return;
        }

        $fail('Must be a valid version in the scheme of MAJOR.MINOR.PATCH');
    }
}
