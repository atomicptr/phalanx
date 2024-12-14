<?php

namespace App\Enums;

use Atomicptr\Functional\Traits\EnumCollectionTrait;

enum Language: string
{
    use EnumCollectionTrait;

    // officially supported languages
    case ENGLISH = 'en';
    case GERMAN = 'de';
    case SPANISH = 'es';
    case FRENCH = 'fr';
    case ITALIAN = 'it';
    case JAPANESE = 'ja';
    case PORTUGUESE = 'pt';
    case RUSSIAN = 'ru';

    // unofficial languages
    case TURKISH = 'tr';
    case HUNGARIAN = 'hu';

    public function crowdinKey(): string
    {
        return match ($this) {
            Language::SPANISH => 'es-ES',
            Language::PORTUGUESE => 'pt-BR',
            default => $this->value,
        };
    }
}
