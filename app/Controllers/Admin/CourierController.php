<?php

namespace App\Controllers\Admin;

use App\Models\Courier;
use App\Models\CourierFile;
use App\Models\CourierStatusHistory;
use App\Models\User;
use Bow\Http\Request;

class CourierController
{
    /**
     * List all couriers
     *
     * @param Request $request
     * @return string
     */
    public function index(Request $request): string
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $agent_id = $request->get('agent_id');

        $query = Courier::query();

        if ($search) {
            $query->where('tracking_number', 'LIKE', "%{$search}%")
                ->orWhere('sender_name', 'LIKE', "%{$search}%")
                ->orWhere('receiver_name', 'LIKE', "%{$search}%")
                ->orWhere('sender_phone', 'LIKE', "%{$search}%")
                ->orWhere('receiver_phone', 'LIKE', "%{$search}%");
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($agent_id) {
            $query->where('agent_id', $agent_id);
        }

        $couriers = $query->orderBy('created_at', 'desc')->get();
        $agents = User::where('role', 'agent')->get();
        $statuses = Courier::getStatusOptions();

        return view('admin.couriers.index', compact('couriers', 'agents', 'statuses', 'search', 'status', 'agent_id'));
    }

    /**
     * Show courier details
     *
     * @param int $id
     * @return string
     */
    public function show(int $id): string
    {
        $courier = Courier::find($id);

        if (!$courier) {
            return redirect('/admin/couriers')->withFlash('error', 'Colis non trouvé');
        }

        $history = CourierStatusHistory::where('courier_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $files = CourierFile::where('courier_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.couriers.show', compact('courier', 'history', 'files'));
    }

    /**
     * Update courier status
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function updateStatus(Request $request, int $id)
    {
        $courier = Courier::find($id);

        if (!$courier) {
            return redirect('/admin/couriers')->withFlash('error', 'Colis non trouvé');
        }

        $request->validate([
            'status' => 'required'
        ]);

        $oldStatus = $courier->status;
        $newStatus = $request->get('status');

        $courier->status = $newStatus;
        $courier->save();

        // Create status history
        \App\Models\CourierStatusHistory::create([
            'courier_id' => $courier->id,
            'changed_by' => auth()->user()->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'comment' => $request->get('comment')
        ]);

        return redirect("/admin/couriers/{$id}")->withFlash('success', 'Statut mis à jour avec succès');
    }
}
