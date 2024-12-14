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
    case CHINESE_SIMPLIFIED = 'zh';
    case CHINESE_TRADITIONAL = 'zx'; // this is a custom key we use in crowdin because in reality the ISO codes don't differentiate

    // unofficial languages
    case TURKISH = 'tr';
    case HUNGARIAN = 'hu';

    public function crowdinKey(): string
    {
        return match ($this) {
            Language::SPANISH => 'es-ES',
            Language::PORTUGUESE => 'pt-BR',
            Language::CHINESE_SIMPLIFIED => 'zh-CN',
            Language::CHINESE_TRADITIONAL => 'zh-TW',
            default => $this->value,
        };
    }
}
