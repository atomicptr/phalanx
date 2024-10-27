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
            self::ALACRITY => asset('icons/alacrity.png'),
            self::BRUTALITY => asset('icons/brutality.png'),
            self::FINESSE => asset('icons/finesse.png'),
            self::FORTITUDE => asset('icons/fortitude.png'),
            self::INSIGHT => asset('icons/insight.png'),
        };
    }

    public function displayString(): string
    {
        return match ($this) {
            self::ALACRITY => 'Alacrity',
            self::BRUTALITY => 'Brutality',
            self::FINESSE => 'Finesse',
            self::FORTITUDE => 'Fortitude',
            self::INSIGHT => 'Insight',
        };
    }
}
