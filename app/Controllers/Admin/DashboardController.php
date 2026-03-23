<?php

namespace App\Controllers\Admin;

use App\Enums\CourierDirection;
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
        // General stats
        $stats = [
            'total_agents' => User::where('role', 'agent')->count(),
            'active_agents' => User::where('role', 'agent')->where('is_active', true)->count(),
            'total_couriers' => Courier::count(),
            'pending_couriers' => Courier::where('status', 'pending')->count(),
            'delivered_couriers' => Courier::where('status', 'delivered')->count(),
            'in_transit_couriers' => Courier::where('status', 'in_transit')->count(),
        ];

        // Direction-based stats (Réception / Départ)
        $directionStats = [
            'incoming' => [
                'total' => Courier::where('direction', CourierDirection::INCOMING->value)->count(),
                'pending' => Courier::where('direction', CourierDirection::INCOMING->value)->where('status', 'pending')->count(),
                'delivered' => Courier::where('direction', CourierDirection::INCOMING->value)->where('status', 'delivered')->count(),
                'in_transit' => Courier::where('direction', CourierDirection::INCOMING->value)->where('status', 'in_transit')->count(),
            ],
            'outgoing' => [
                'total' => Courier::where('direction', CourierDirection::OUTGOING->value)->count(),
                'pending' => Courier::where('direction', CourierDirection::OUTGOING->value)->where('status', 'pending')->count(),
                'delivered' => Courier::where('direction', CourierDirection::OUTGOING->value)->where('status', 'delivered')->count(),
                'in_transit' => Courier::where('direction', CourierDirection::OUTGOING->value)->where('status', 'in_transit')->count(),
            ],
        ];

        // Today's stats
        $today = date('Y-m-d');
        $todayStats = [
            'incoming' => Courier::where('direction', CourierDirection::INCOMING->value)
                ->where('created_at', '>=', $today . ' 00:00:00')
                ->count(),
            'outgoing' => Courier::where('direction', CourierDirection::OUTGOING->value)
                ->where('created_at', '>=', $today . ' 00:00:00')
                ->count(),
        ];

        // This month stats
        $monthStart = date('Y-m-01');
        $monthStats = [
            'incoming' => Courier::where('direction', CourierDirection::INCOMING->value)
                ->where('created_at', '>=', $monthStart . ' 00:00:00')
                ->count(),
            'outgoing' => Courier::where('direction', CourierDirection::OUTGOING->value)
                ->where('created_at', '>=', $monthStart . ' 00:00:00')
                ->count(),
        ];

        $recent_couriers = Courier::orderBy('created_at', 'desc')->take(10)->get();
        $recent_agents = User::where('role', 'agent')->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'stats',
            'directionStats',
            'todayStats',
            'monthStats',
            'recent_couriers',
            'recent_agents'
        ));
    }
}
