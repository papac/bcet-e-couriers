<?php

namespace App\Controllers\Auth;

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
    public function showLoginForm(Request $request): string
    {
        if (Auth::check()) {
            return redirect($request->user()->isAdmin() ? '/admin' : '/agent');
        }

        return view('auth.login');
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
            return redirect('/login')->withFlash('error', 'Email ou mot de passe incorrect');
        }

        // Check if user is active
        if (!$user->is_active) {
            return redirect('/login')->withFlash('error', 'Votre compte a été désactivé');
        }

        // Attempt login
        if (Auth::attempts($credentials)) {
            // Clear rate limit on successful login
            LoginRateLimitMiddleware::clearAttempts($request);
            
            $user = Auth::user();
            
            // Redirect based on role
            if ($user->isAdmin()) {
                return redirect('/admin');
            }
            
            return redirect('/agent');
        }

        // Increment failed attempts
        LoginRateLimitMiddleware::incrementAttempts($request);

        return redirect('/login')->withFlash('error', 'Email ou mot de passe incorrect');
    }

    /**
     * Handle logout
     *
     * @return mixed
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        return redirect('/login')->withFlash('success', 'Vous avez été déconnecté');
    }
}
