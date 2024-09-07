<?php

namespace App\Utils;

use Illuminate\Support\Facades\Route;

class RouteUtil
{
    public static function active(string $name): string
    {
        return str_starts_with(Route::currentRouteName(), $name) ? 'active' : '';
    }
}
