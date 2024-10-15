<?php

namespace App\Enums;

use App\Contracts\DisplayAsString;

enum WeaponTalentOptionType: string implements DisplayAsString
{
    case STAT = 'stat';
    case CUSTOM = 'custom';

    public function displayString(): string
    {
        return match ($this) {
            self::STAT => 'Stat',
            self::CUSTOM => 'Custom',
            default => $this->value,
        };
    }
}
