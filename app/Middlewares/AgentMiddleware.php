<?php

namespace App\Middlewares;

use Bow\Http\Request;
use Bow\Auth\Auth;

class AgentMiddleware
{
    /**
     * Handle the incoming request
     *
     * @param Request $request
     * @param callable $next
     * @return mixed
     */
    public function handle(Request $request, callable $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if (!$user->isAgent() && !$user->isAdmin()) {
            return redirect('/login')->withFlash('error', 'Accès non autorisé');
        }

        return $next($request);
    }
}
