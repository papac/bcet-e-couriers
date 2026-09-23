<?php

namespace App\Middlewares;

use Bow\Http\Request;
use Bow\Auth\Auth;
use Bow\Middleware\BaseMiddleware;

class AdminMiddleware implements BaseMiddleware
{
    /**
     * Handle the incoming request
     *
     * @param Request $request
     * @param callable $next
     * @return mixed
     */
    public function process(Request $request, callable $next, array $args = []): mixed
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if (!$user->isAdmin()) {
            return redirect(route('dashboard'))->withFlash('error', 'Accès non autorisé');
        }

        return $next($request);
    }
}
