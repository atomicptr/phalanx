<?php

namespace App\Enums;

use App\Traits\EnumValuesTrait;

enum ItemType: string
{
    use EnumValuesTrait;

    case OMNICELL = 'omnicell';
    case WEAPON = 'weapon';
    case ARMOR = 'armor';
    case LANTERN = 'lantern';
    case CELL = 'cell';
}
