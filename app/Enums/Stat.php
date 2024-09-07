<?php

namespace App\Enums;

enum Stat: string
{
    case MIGHT = 'might';
    case CRITICAL = 'critical';
    case SPEED = 'speed';
    case VITALITY = 'vitality';
    case DEFENSE = 'defense';
    case ENDURANCE = 'endurance';
}
