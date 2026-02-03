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
        $user = auth()->user();

        if ($user->role === 'admin') {
            return (new AdminDashboardController())->index();
        }

        return (new AgentDashboardController())->index();
    }
}
