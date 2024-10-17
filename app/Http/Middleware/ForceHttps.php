<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isSupportedEnv = in_array(env('APP_ENV'), ['stage', 'production']);

        if (! $request->isSecure() && $isSupportedEnv) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
