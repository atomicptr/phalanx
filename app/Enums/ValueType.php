<?php

namespace App\Enums;

use App\Contracts\DisplayAsString;

enum ValueType: string implements DisplayAsString
{
    case CUSTOM = 'custom';
    case STAT = 'stat';
    case PERK = 'perk';

    public function hasStatField(): bool
    {
        return match ($this) {
            self::STAT => true,
            default => false,
        };
    }

    public function displayString(): string
    {
        return match ($this) {
            self::CUSTOM => 'Custom',
            self::STAT => 'Stat',
            self::PERK => 'Perk',
            default => $this->value,
        };
    }
}
