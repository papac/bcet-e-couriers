<?php

namespace App\Middlewares;

use App\Enums\AppAccess;
use Bow\Http\Request;
use Bow\Middleware\BaseMiddleware;

class AppAccessMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request
     *
     * @param Request $request
     * @param callable $next
     * @param array $params Middleware parameters [app]
     * @return mixed
     */
    public function process(Request $request, callable $next, array $params = [])
    {
        $user = app_auth()->user();

        if (!$user) {
            return redirect('/login');
        }

        // Get the app from middleware parameter
        $app = $params[0] ?? null;

        if (!$app) {
            return $next($request);
        }

        // Try to get AppAccess enum case
        $appEnum = AppAccess::tryFrom($app);

        if (!$appEnum) {
            return redirect('/app')->withFlash('error', 'Application invalide');
        }

        // Check if user has access to this app
        if (!$user->hasAppAccess($appEnum)) {
            return redirect('/app')->withFlash('error', "Vous n'avez pas accès à l'application " . $appEnum->label());
        }

        return $next($request);
    }
}
