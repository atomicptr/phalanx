<?php

namespace App\Utils;

use Illuminate\Support\Facades\Route;

class RouteUtil
{
    public static function active(string $name): string
    {
        return Route::currentRouteName() === $name ? 'active' : '';
    }
}
