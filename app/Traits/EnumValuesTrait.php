<?php

namespace App\Traits;

use Atomicptr\Functional\Lst;

trait EnumValuesTrait
{
    public static function values(): array
    {
        return Lst::map(fn ($elem) => $elem->value, static::cases());
    }
}
