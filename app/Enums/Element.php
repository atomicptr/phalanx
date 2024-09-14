<?php

namespace App\Enums;

use App\Contracts\DisplayAsString;
use App\Traits\EnumValuesTrait;

enum Element: string implements DisplayAsString
{
    use EnumValuesTrait;

    case BLAZE = 'blaze';
    case FROST = 'frost';
    case SHOCK = 'shock';
    case TERRA = 'terra';
    case RADIANT = 'radiant';
    case UMBRAL = 'umbral';

    public function displayString(): string
    {
        return match ($this) {
            self::BLAZE => 'Blaze',
            self::FROST => 'Frost',
            self::SHOCK => 'Shock',
            self::TERRA => 'Terra',
            self::RADIANT => 'Radiant',
            self::UMBRAL => 'Umbral',
        };
    }

    public function opposite(): ?Element
    {
        return match ($this) {
            self::BLAZE => self::FROST,
            self::FROST => self::BLAZE,
            self::SHOCK => self::TERRA,
            self::TERRA => self::SHOCK,
            self::RADIANT => self::UMBRAL,
            self::UMBRAL => self::RADIANT,
        };
    }
}
