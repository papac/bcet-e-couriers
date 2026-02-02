<?php

namespace App\Controllers\Admin;

use App\Models\User;
use App\Models\Courier;
use Bow\Http\Request;

class DashboardController
{
    /**
     * Show admin dashboard
     *
     * @return string
     */
    public function index(): string
    {
        $stats = [
            'total_agents' => User::where('role', 'agent')->count(),
            'active_agents' => User::where('role', 'agent')->where('is_active', true)->count(),
            'total_couriers' => Courier::count(),
            'pending_couriers' => Courier::where('status', 'pending')->count(),
            'delivered_couriers' => Courier::where('status', 'delivered')->count(),
            'in_transit_couriers' => Courier::where('status', 'in_transit')->count(),
        ];

        $recent_couriers = Courier::orderBy('created_at', 'desc')->take(10)->get();
        $recent_agents = User::where('role', 'agent')->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_couriers', 'recent_agents'));
    }
}
