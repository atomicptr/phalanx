<?php

namespace App\Service;

final class TranslationService
{
    public static function i18n(string $model, int $id, string $field, ?string $default): ?array
    {
        if ($default === null) {
            return null;
        }

        // TODO: load other translations
        return [
            'en' => $default,
        ];
    }
}
