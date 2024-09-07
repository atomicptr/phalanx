<?php

namespace App\Enums;

use App\Contracts\DisplayAsString;
use App\Traits\EnumValuesTrait;

enum WeaponType: string implements DisplayAsString
{
    use EnumValuesTrait;

    case AETHER_STRIKERS = 'aether_strikers';
    case AXE = 'axe';
    case CHAIN_BLADES = 'chain_blades';
    case HAMMER = 'hammer';
    case OSTIAN_REPEATERS = 'ostian_repeaters';
    case SWORD = 'sword';
    case WAR_PIKE = 'war_pike';

    public function displayString(): string
    {
        return match ($this) {
            self::AETHER_STRIKERS => 'Aether Strikers',
            self::AXE => 'Axe',
            self::CHAIN_BLADES => 'Chain Blades',
            self::HAMMER => 'Hammer',
            self::OSTIAN_REPEATERS => 'Ostian Repeaters',
            self::SWORD => 'Sword',
            self::WAR_PIKE => 'War Pike',
        };
    }
}
