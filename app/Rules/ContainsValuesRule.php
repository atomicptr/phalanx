<?php

namespace App\Rules;

use Atomicptr\Functional\Lst;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ContainsValuesRule implements ValidationRule
{
    private const REGEX = '/\{([a-zA-Z0-9]+)\}/m';

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

        $matches = [];
        preg_match_all(static::REGEX, $value, $matches, PREG_SET_ORDER, 0);

        foreach ($matches as $match) {
            $key = $match[1];

            $has = Lst::some(fn (array $val) => $val['name'] === $key, $this->values);

            if (! $has) {
                $fail("Unknown variable '$key'");

                return;
            }
        }
    }
}
