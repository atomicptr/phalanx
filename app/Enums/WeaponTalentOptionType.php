<?php

namespace App\Enums;

use App\Contracts\DisplayAsString;

enum WeaponTalentOptionType: string implements DisplayAsString
{
    case STAT = 'stat';
    case PERK = 'perk';
    case CUSTOM = 'custom';

    public function displayString(): string
    {
        return match ($this) {
            self::STAT => 'Stat',
            self::PERK => 'Perk',
            self::CUSTOM => 'Custom',
            default => $this->value,
        };
    }
}
