<?php

namespace App\Middlewares;

use Bow\Http\Request;
use Bow\Cache\Cache;

class LoginRateLimitMiddleware
{
    /**
     * Maximum login attempts
     */
    private int $maxAttempts = 5;

    /**
     * Lockout time in minutes
     */
    private int $lockoutMinutes = 15;

    /**
     * Handle the incoming request
     *
     * @param Request $request
     * @param callable $next
     * @return mixed
     */
    public function process(Request $request, callable $next)
    {
        $key = $this->getThrottleKey($request);
        $attempts = (int) Cache::get($key, 0);

        if ($attempts >= $this->maxAttempts) {
            $remainingTime = Cache::get($key . ':lockout_time', 0);

            return redirect('/login')->withFlash(
                'error',
                "Trop de tentatives de connexion. Veuillez réessayer dans {$this->lockoutMinutes} minutes."
            );
        }

        $response = $next($request);

        return $response;
    }

    /**
     * Increment the login attempts
     *
     * @param Request $request
     * @return void
     */
    public static function incrementAttempts(Request $request): void
    {
        $key = self::staticGetThrottleKey($request);
        $attempts = (int) Cache::get($key, 0);

        Cache::set($key, $attempts + 1, 15 * 60); // 15 minutes
        Cache::set($key . ':lockout_time', time() + (15 * 60), 15 * 60);
    }

    /**
     * Clear the login attempts
     *
     * @param Request $request
     * @return void
     */
    public static function clearAttempts(Request $request): void
    {
        $key = self::staticGetThrottleKey($request);
        Cache::forget($key);
        Cache::forget($key . ':lockout_time');
    }

    /**
     * Get the throttle key
     *
     * @param Request $request
     * @return string
     */
    protected function getThrottleKey(Request $request): string
    {
        return self::staticGetThrottleKey($request);
    }

    /**
     * Static method to get throttle key
     *
     * @param Request $request
     * @return string
     */
    protected static function staticGetThrottleKey(Request $request): string
    {
        $ip = $request->ip() ?? 'unknown';
        $email = strtolower($request->get('email', ''));

        return 'login_attempts:' . sha1($ip . '|' . $email);
    }
}
