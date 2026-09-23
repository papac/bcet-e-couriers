<?php

namespace App\Controllers;

use App\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Controllers\Agent\DashboardController as AgentDashboardController;
use Bow\Http\Request;

class DashboardController
{
    /**
     * Show dashboard based on user role
     *
     * @return string
     */
    public function index(): string
    {
        $user = app_auth()->user();

        if ($user === null) {
            app_auth()->logout();

            return redirect()->route('auth.index');
        }

        if ($user->role === 'admin') {
            return (new AdminDashboardController())->index();
        }

        return (new AgentDashboardController())->index();
    }
}
