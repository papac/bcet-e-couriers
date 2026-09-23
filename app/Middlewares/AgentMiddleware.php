<?php

namespace App\Middlewares;

use Bow\Http\Request;
use Bow\Auth\Auth;
use Bow\Middleware\BaseMiddleware;

class AgentMiddleware implements BaseMiddleware
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

        // Admins have their own courier screens
        if ($user->isAdmin()) {
            return redirect(route('admin.couriers.index'));
        }

        if (!$user->isAgent()) {
            return redirect(route('auth.index'))->withFlash('error', 'Accès non autorisé');
        }

        return $next($request);
    }
}
