<?php

namespace App\Enums;

use App\Contracts\DisplayAsString;

enum Stat: string implements DisplayAsString
{
    case MIGHT = 'might';
    case CRITICAL = 'critical';
    case SPEED = 'speed';
    case VITALITY = 'vitality';
    case DEFENSE = 'defense';
    case ENDURANCE = 'endurance';

    public function displayString(): string
    {
        return match ($this) {
            self::MIGHT => 'Might',
            self::CRITICAL => 'Critical',
            self::SPEED => 'Speed',
            self::VITALITY => 'Vitality',
            self::DEFENSE => 'Defense',
            self::ENDURANCE => 'Endurance',
        };
    }
}
