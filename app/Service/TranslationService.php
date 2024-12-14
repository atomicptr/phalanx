<?php

namespace App\Service;

use App\Models\Translation;
use Atomicptr\Functional\Lst;
use Atomicptr\Functional\Map;
use Illuminate\Support\Str;

final class TranslationService
{
    private static ?array $data = null;

    private static function load(): void
    {
        $data = Translation::all()->toArray();

        $newData = [];

        foreach ($data as $item) {
            $ident = $item['ident'];

            if (! array_key_exists($ident, $newData)) {
                $newData[$ident] = [];
            }

            $newData[$ident][] = $item;
        }

        self::$data = $newData;
    }

    private static function get(string $ident): array
    {
        if (self::$data === null) {
            self::load();
        }

        if (array_key_exists($ident, self::$data)) {
            return self::$data[$ident];
        }

        return [];
    }

    public static function makeIdent(string $model, int $id, string $field): string
    {
        return Str::slug(implode('-', [$model, $id, $field]), dictionary: [
            '@' => 'at',
            '\\' => '-',
        ]);
    }

    public static function i18n(string $model, int $id, string $field, ?string $default): ?array
    {
        if (empty($default)) {
            return null;
        }

        $ident = self::makeIdent($model, $id, $field);

        $translations = Map::fromList(Lst::map(fn (array $t) => [$t['language'], $t['content']], self::get($ident)));

        return [
            ...$translations->toArray(),
            'en' => $default,
        ];
    }
}
