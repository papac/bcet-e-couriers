<?php

namespace App\Middlewares;

use Bow\Http\Request;
use Bow\Cache\Cache;

class RateLimitMiddleware
{
    /**
     * Maximum number of requests allowed
     */
    private int $maxAttempts = 60;

    /**
     * Time window in seconds
     */
    private int $decayMinutes = 1;

    /**
     * Handle the incoming request
     *
     * @param Request $request
     * @param callable $next
     * @return mixed
     */
    public function process(Request $request, callable $next)
    {
        $key = $this->resolveRequestSignature($request);
        $attempts = (int) Cache::get($key, 0);

        if ($attempts >= $this->maxAttempts) {
            return response()->json([
                'error' => 'Too many requests. Please try again later.',
                'retry_after' => $this->decayMinutes * 60
            ], 429);
        }

        Cache::set($key, $attempts + 1, $this->decayMinutes * 60);

        $response = $next($request);

        return $response;
    }

    /**
     * Resolve request signature for rate limiting
     *
     * @param Request $request
     * @return string
     */
    protected function resolveRequestSignature(Request $request): string
    {
        $ip = $request->ip() ?? 'unknown';
        $route = $request->url();

        return 'rate_limit:' . sha1($ip . '|' . $route);
    }
}
