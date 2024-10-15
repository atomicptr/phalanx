<?php

namespace App\Utils;

final class NumberUtil
{
    public static function parse(mixed $number): mixed
    {
        if (! is_numeric($number)) {
            return $number;
        }

        if (str_contains($number, '.')) {
            return floatval($number);
        }

        return intval($number);
    }
}
