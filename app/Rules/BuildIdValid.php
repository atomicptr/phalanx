<?php

namespace App\Rules;

use Closure;
use DauntlessBuilder\Build;
use Illuminate\Contracts\Validation\ValidationRule;

class BuildIdValid implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $build = Build::fromId($value);

        if ($build->hasError()) {
            $fail('Is not a valid build id');
        }
    }
}
