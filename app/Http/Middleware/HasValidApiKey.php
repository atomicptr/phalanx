<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class HasValidApiKey
{
    private const QUERY_NAME = 'api_key';

    private const HEADER_NAME = 'X-Phalanx-Api-Key';

    public function handle(Request $request, Closure $next): Response
    {
        // ignore debug context
        if (App::hasDebugModeEnabled()) {
            return $next($request);
        }

        // we only care about API requests
        if (! str_starts_with($request->path(), 'api/')) {
            return $next($request);
        }

        $apiKey = $request->get(self::QUERY_NAME) ?? $request->header(self::HEADER_NAME);

        if (! $apiKey) {
            throw new AuthorizationException('Invalid API key');
        }

        $keyRecord = ApiKey::query()->where('api_key', $apiKey)->first();

        if (! $keyRecord) {
            throw new AuthorizationException('Invalid API key');
        }

        return $next($request);
    }
}
