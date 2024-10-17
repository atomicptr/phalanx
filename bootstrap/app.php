<?php

use App\Http\Middleware\ForceHttps;
use App\Http\Middleware\HasValidApiKey;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        if (env('TRUST_ALL_PROXIES')) {
            $middleware->trustProxies(at: '*');
        }

        $middleware->append([
            ForceHttps::class,
            HasValidApiKey::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
