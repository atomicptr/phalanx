<?php

namespace App\Enums;

use App\Contracts\DisplayAsString;
use App\Traits\EnumValuesTrait;

enum ArmourType: string implements DisplayAsString
{
    use EnumValuesTrait;

    case HEAD = 'head';
    case TORSO = 'torso';
    case ARMS = 'arms';
    case LEGS = 'legs';

    public function displayString(): string
    {
        return match ($this) {
            self::HEAD => 'Head',
            self::TORSO => 'Torso',
            self::ARMS => 'Arms',
            self::LEGS => 'Legs',
            default => $this->value,
        };
    }
}
