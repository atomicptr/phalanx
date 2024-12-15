<?php

namespace App\Rules;

use Atomicptr\Functional\Lst;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PerkABCDRule implements ValidationRule
{
    public function __construct(
        private array $others
    ) {}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === 0) {
            $fail('No value selected');
        }

        if (Lst::some(fn (?int $id) => $value === $id, $this->others)) {
            $fail('Perk can not be picked twice');
        }
    }
}
