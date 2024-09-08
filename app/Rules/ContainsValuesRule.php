<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ContainsValuesRule implements ValidationRule
{
    public function __construct(
        private array $values,
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null) {
            return;
        }

        foreach ($this->values as $v) {
            $key = $v['name'];

            if (! str_contains($value, '{'.$key.'}')) {
                $fail("Must contain variable '$key'");

                return;
            }
        }
    }
}
