<?php

namespace App\Controllers\Admin;

use App\Enums\CourierDirection;
use App\Models\Courier;
use App\Models\CourierFile;
use App\Models\CourierStatusHistory;
use App\Models\Service;
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
        $direction = $request->get('direction');
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

        if ($direction) {
            $query->where('direction', $direction);
        }

        if ($agent_id) {
            $query->where('agent_id', $agent_id);
        }

        $couriers = $query->orderBy('created_at', 'desc')->get();
        $agents = User::where('role', 'agent')->get();
        $statuses = Courier::getStatusOptions();
        $directions = Courier::getDirectionOptions();

        return view('admin.couriers.index', compact('couriers', 'agents', 'statuses', 'directions', 'search', 'status', 'direction', 'agent_id'));
    }

    /**
     * Show create form for incoming courier (Réception)
     *
     * @return string
     */
    public function createIncoming(): string
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $direction = CourierDirection::INCOMING;

        return view('admin.couriers.create', compact('services', 'direction'));
    }

    /**
     * Show create form for outgoing courier (Départ)
     *
     * @return string
     */
    public function createOutgoing(): string
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $direction = CourierDirection::OUTGOING;

        return view('admin.couriers.create', compact('services', 'direction'));
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
            'sender_name' => 'required|min:2',
            'sender_phone' => 'required|min:8',
            'receiver_name' => 'required|min:2',
            'receiver_phone' => 'required|min:8',
            'direction' => 'required'
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
        $courier->direction = $request->get('direction');
        $courier->status = Courier::STATUS_PENDING;
        $courier->agent_id = auth()->user()->id;
        $courier->notes = $request->get('notes');
        $courier->courier_type = $request->get('courier_type', Courier::TYPE_INDIVIDUAL);
        $courier->origin_service_id = $request->get('origin_service_id');
        $courier->destination_service_id = $request->get('destination_service_id');

        $courier->persist();

        // Handle file uploads
        $this->handleFileUploads($request, $courier->id);

        $directionLabel = CourierDirection::tryFrom($request->get('direction'))?->label() ?? '';

        return redirect('/app/couriers')->withFlash('success', "Courrier ({$directionLabel}) créé avec succès - N° {$courier->tracking_number}");
    }

    /**
     * Handle file uploads for a courier
     *
     * @param Request $request
     * @param int $courierId
     * @return void
     */
    protected function handleFileUploads(Request $request, int $courierId): void
    {
        $files = $request->file('documents');

        if (empty($files) || !is_array($files['name'])) {
            return;
        }

        // Create upload directory if not exists
        $uploadDir = storage_path('couriers');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Also create public symlink directory
        $publicDir = public_path('storage/couriers');
        if (!is_dir($publicDir)) {
            mkdir($publicDir, 0755, true);
        }

        $fileCount = count(array_filter($files['name']));

        // Check max files limit
        $existingCount = CourierFile::where('courier_id', $courierId)->count();
        if ($existingCount + $fileCount > CourierFile::MAX_FILES_PER_COURIER) {
            return;
        }

        $courier = Courier::find($courierId);

        for ($i = 0; $i < $fileCount; $i++) {
            if (empty($files['name'][$i]) || $files['error'][$i] !== UPLOAD_ERR_OK) {
                continue;
            }

            $file = [
                'name' => $files['name'][$i],
                'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i]
            ];

            // Validate file extension
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($extension, CourierFile::ALLOWED_EXTENSIONS)) {
                continue;
            }

            // Validate file size
            if ($file['size'] > CourierFile::MAX_FILE_SIZE) {
                continue;
            }

            // Generate unique filename
            $filename = $courier->tracking_number . '_' . uniqid() . '.' . $extension;
            $filepath = $uploadDir . '/' . $filename;

            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $filepath)) {
                // Copy to public directory for access
                copy($filepath, $publicDir . '/' . $filename);

                // Get actual MIME type
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->file($filepath);

                // Create database record
                CourierFile::create([
                    'courier_id' => $courierId,
                    'filename' => $filename,
                    'original_name' => $file['name'],
                    'mime_type' => $mimeType,
                    'size' => $file['size'],
                    'path' => 'couriers/' . $filename,
                    'uploaded_by' => auth()->user()->id
                ]);
            }
        }
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
            return redirect('/app/couriers')->withFlash('error', 'Colis non trouvé');
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
     * Show edit form
     *
     * @param int $id
     * @return string
     */
    public function edit(int $id): string
    {
        $courier = Courier::find($id);

        if (!$courier) {
            return redirect('/app/couriers')->withFlash('error', 'Colis non trouvé');
        }

        $services = Service::where('is_active', true)->orderBy('name')->get();
        $directions = Courier::getDirectionOptions();

        return view('admin.couriers.edit', compact('courier', 'services', 'directions'));
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
        $courier = Courier::find($id);

        if (!$courier) {
            return redirect('/app/couriers')->withFlash('error', 'Colis non trouvé');
        }

        $request->validate([
            'sender_name' => 'required|min:2',
            'sender_phone' => 'required|min:8',
            'receiver_name' => 'required|min:2',
            'receiver_phone' => 'required|min:8',
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
        $courier->courier_type = $request->get('courier_type', $courier->courier_type);
        $courier->origin_service_id = $request->get('origin_service_id');
        $courier->destination_service_id = $request->get('destination_service_id');

        $courier->persist();

        return redirect("/app/couriers/{$id}")->withFlash('success', 'Courrier mis à jour avec succès');
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
            return redirect('/app/couriers')->withFlash('error', 'Colis non trouvé');
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
            'changed_by' => auth()->user()->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'comment' => $request->get('comment')
        ]);

        return redirect("/app/couriers/{$id}")->withFlash('success', 'Statut mis à jour avec succès');
    }
}
