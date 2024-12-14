<?php

namespace App\Service;

use App\Models\Translation;
use Atomicptr\Functional\Lst;
use Atomicptr\Functional\Map;
use Illuminate\Support\Str;

final class TranslationService
{
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

        $translations = Map::fromList(Lst::map(fn (array $t) => [$t['language'], $t['content']], Translation::where(['ident' => $ident])->get()->toArray()));

        return [
            ...$translations->toArray(),
            'en' => $default,
        ];
    }
}
