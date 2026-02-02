<?php

namespace App\Controllers\Agent;

use App\Models\Courier;
use Bow\Http\Request;

class DashboardController
{
    /**
     * Show agent dashboard
     *
     * @return string
     */
    public function index(): string
    {
        $user = auth()->user();
        
        $stats = [
            'total_couriers' => Courier::where('agent_id', $user->id)->count(),
            'pending_couriers' => Courier::where('agent_id', $user->id)->where('status', 'pending')->count(),
            'delivered_couriers' => Courier::where('agent_id', $user->id)->where('status', 'delivered')->count(),
            'in_transit_couriers' => Courier::where('agent_id', $user->id)->where('status', 'in_transit')->count(),
        ];

        $recent_couriers = Courier::where('agent_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('agent.dashboard', compact('stats', 'recent_couriers'));
    }
}
