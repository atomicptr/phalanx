<?php

namespace App\Enums;

use App\Contracts\DisplayAsString;
use App\Contracts\HasIcon;
use App\Traits\EnumValuesTrait;

enum PerkType: string implements DisplayAsString, HasIcon
{
    use EnumValuesTrait;

    case ALACRITY = 'alacrity';
    case BRUTALITY = 'brutality';
    case FINESSE = 'finesse';
    case FORTITUDE = 'fortitude';
    case INSIGHT = 'insight';

    public function icon(): string
    {
        return match ($this) {
            self::ALACRITY => asset('icons/mobility.svg'),
            self::BRUTALITY => asset('icons/power.svg'),
            self::FINESSE => asset('icons/technique.svg'),
            self::FORTITUDE => asset('icons/defense.svg'),
            self::INSIGHT => asset('icons/utility.svg'),
        };
    }

    public function displayString(): string
    {
        return match ($this) {
            self::ALACRITY => 'Mobility',
            self::BRUTALITY => 'Power',
            self::FINESSE => 'Technique',
            self::FORTITUDE => 'Defense',
            self::INSIGHT => 'Utility',
        };
    }
}
