<?php

namespace App\Utils;

use App\Enums\ValueType;
use Atomicptr\Functional\Lst;
use Illuminate\Support\Str;

class ValuesUtil
{
    public static function prepare(array $values): array
    {
        return Lst::map(
            fn (array $value) => [...$value, 'type' => $value['type'] instanceof ValueType ? $value['type'] : ValueType::from($value['type'])],
            Lst::map(
                fn (array $value) => array_merge(
                    [
                        'id' => (string) Str::uuid(),
                        'name' => '',
                        'value' => '',
                        'type' => ValueType::CUSTOM,
                    ],
                    $value
                ),
                $values
            )
        );
    }

    public static function clean(array $values): array
    {
        return Lst::filter(fn (array $values) => ! empty($values['name']) && ! empty($values['value']), $values);
    }

    public static function add(array $values): array
    {
        return Lst::cons($values, ['id' => (string) Str::uuid(), 'name' => '', 'value' => '', 'type' => ValueType::CUSTOM]);
    }

    public static function remove(array $values, int $index): array
    {
        return Lst::filter(fn (array $val, int $idx) => $index !== $idx, $values);
    }
}
