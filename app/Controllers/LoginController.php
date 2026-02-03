<?php

namespace App\Controllers;

use App\Models\User;
use Bow\Http\Request;
use Bow\Auth\Auth;
use App\Middlewares\LoginRateLimitMiddleware;

class LoginController
{
    /**
     * Show login form
     *
     * @return string
     */
    public function __invoke(Request $request): string
    {
        if (Auth::check()) {
            return redirect($request->user()->isAdmin() ? '/admin' : '/agent');
        }

        return view('login');
    }

    /**
     * Handle login
     *
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Find user
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return redirect('/')->withFlash('error', 'Email ou mot de passe incorrect');
        }

        // Check if user is active
        if (!$user->is_active) {
            return redirect('/')->withFlash('error', 'Votre compte a été désactivé');
        }

        // Attempt login
        if (!app_hash($credentials['password'], $user->password)) {
            // Increment failed attempts
            LoginRateLimitMiddleware::incrementAttempts($request);

            return redirect('/')->withFlash('error', 'Email ou mot de passe incorrect');
        }

        // Clear rate limit on successful login
        LoginRateLimitMiddleware::clearAttempts($request);

        app_auth()->login($user);

        return redirect('/');
    }

    /**
     * Handle logout
     *
     * @return mixed
     */
    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/')->withFlash('success', 'Vous avez été déconnecté');
    }
}
