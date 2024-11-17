<?php

namespace App\Enums;

use App\Traits\EnumValuesTrait;

enum BuildCategory: string
{
    use EnumValuesTrait;

    case META_BUILDS = 'meta_builds';
    case TRIAL_BUILDS = 'trial_builds';
    case PROGRESSION_BUILDS = 'progression_builds';
}
