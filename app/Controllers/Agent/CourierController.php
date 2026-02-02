<?php

namespace App\Controllers\Agent;

use App\Models\Courier;
use App\Models\CourierStatusHistory;
use Bow\Http\Request;

class CourierController
{
    /**
     * List agent's couriers
     *
     * @param Request $request
     * @return string
     */
    public function index(Request $request): string
    {
        $user = $request->user();
        $search = $request->get('search');
        $status = $request->get('status');
        
        $query = Courier::where('agent_id', $user->id);
        
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
        
        $couriers = $query->orderBy('created_at', 'desc')->get();
        $statuses = Courier::getStatusOptions();
        
        return view('agent.couriers.index', compact('couriers', 'statuses', 'search', 'status'));
    }

    /**
     * Show create courier form
     *
     * @return string
     */
    public function create(): string
    {
        return view('agent.couriers.create');
    }

    /**
     * Store new courier
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->validate([
            'sender_name' => 'required|min:2|max:100',
            'sender_phone' => 'required|min:8',
            'sender_address' => 'required|min:5',
            'receiver_name' => 'required|min:2|max:100',
            'receiver_phone' => 'required|min:8',
            'receiver_address' => 'required|min:5',
        ]);

        $courier = new Courier();
        $courier->tracking_number = Courier::generateTrackingNumber();
        $courier->sender_name = $request->get('sender_name');
        $courier->sender_phone = $request->get('sender_phone');
        $courier->sender_address = $request->get('sender_address');
        $courier->receiver_name = $request->get('receiver_name');
        $courier->receiver_phone = $request->get('receiver_phone');
        $courier->receiver_address = $request->get('receiver_address');
        $courier->description = $request->get('description');
        $courier->weight = $request->get('weight');
        $courier->price = $request->get('price');
        $courier->status = Courier::STATUS_RECEIVED;
        $courier->agent_id = auth()->user()->id;
        $courier->notes = $request->get('notes');
        $courier->save();

        // Create initial status history
        CourierStatusHistory::create([
            'courier_id' => $courier->id,
            'changed_by' => auth()->user()->id,
            'old_status' => null,
            'new_status' => Courier::STATUS_RECEIVED,
            'comment' => 'Colis reçu et enregistré'
        ]);

        return redirect('/agent/couriers')->withFlash('success', "Colis créé avec succès. N° de suivi: {$courier->tracking_number}");
    }

    /**
     * Show courier details
     *
     * @param int $id
     * @return string
     */
    public function show(int $id): string
    {
        $user = auth()->user();
        $courier = Courier::where('id', $id)->where('agent_id', $user->id)->first();
        
        if (!$courier) {
            return redirect('/agent/couriers')->withFlash('error', 'Colis non trouvé');
        }

        $history = CourierStatusHistory::where('courier_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('agent.couriers.show', compact('courier', 'history'));
    }

    /**
     * Show edit courier form
     *
     * @param int $id
     * @return string
     */
    public function edit(int $id): string
    {
        $user = auth()->user();
        $courier = Courier::where('id', $id)->where('agent_id', $user->id)->first();
        
        if (!$courier) {
            return redirect('/agent/couriers')->withFlash('error', 'Colis non trouvé');
        }

        return view('agent.couriers.edit', compact('courier'));
    }

    /**
     * Update courier
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function update(Request $request, int $id)
    {
        $user = auth()->user();
        $courier = Courier::where('id', $id)->where('agent_id', $user->id)->first();
        
        if (!$courier) {
            return redirect('/agent/couriers')->withFlash('error', 'Colis non trouvé');
        }

        $request->validate([
            'sender_name' => 'required|min:2|max:100',
            'sender_phone' => 'required|min:8',
            'sender_address' => 'required|min:5',
            'receiver_name' => 'required|min:2|max:100',
            'receiver_phone' => 'required|min:8',
            'receiver_address' => 'required|min:5',
        ]);

        $courier->sender_name = $request->get('sender_name');
        $courier->sender_phone = $request->get('sender_phone');
        $courier->sender_address = $request->get('sender_address');
        $courier->receiver_name = $request->get('receiver_name');
        $courier->receiver_phone = $request->get('receiver_phone');
        $courier->receiver_address = $request->get('receiver_address');
        $courier->description = $request->get('description');
        $courier->weight = $request->get('weight');
        $courier->price = $request->get('price');
        $courier->notes = $request->get('notes');
        $courier->save();

        return redirect('/agent/couriers')->withFlash('success', 'Colis mis à jour avec succès');
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
        $user = auth()->user();
        $courier = Courier::where('id', $id)->where('agent_id', $user->id)->first();
        
        if (!$courier) {
            return redirect('/agent/couriers')->withFlash('error', 'Colis non trouvé');
        }

        $request->validate([
            'status' => 'required'
        ]);

        $oldStatus = $courier->status;
        $newStatus = $request->get('status');
        
        $courier->status = $newStatus;
        $courier->save();

        // Create status history
        CourierStatusHistory::create([
            'courier_id' => $courier->id,
            'changed_by' => $user->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'comment' => $request->get('comment')
        ]);

        return redirect("/agent/couriers/{$id}")->withFlash('success', 'Statut mis à jour avec succès');
    }
}
