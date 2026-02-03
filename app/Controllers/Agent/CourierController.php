<?php

namespace App\Controllers\Agent;

use App\Models\Courier;
use App\Models\CourierFile;
use App\Models\CourierStatusHistory;
use App\Models\Service;
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
        $services = Service::where('is_active', true)->orderBy('name')->get();
        return view('agent.couriers.create', compact('services'));
    }

    /**
     * Store new courier
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $type = $request->get('type', Courier::TYPE_INDIVIDUAL);

        // Validation rules based on type
        $rules = [
            'sender_name' => 'required|min:2|max:100',
            'sender_phone' => 'required|min:8',
            'sender_address' => 'required|min:5',
            'receiver_name' => 'required|min:2|max:100',
            'receiver_phone' => 'required|min:8',
            'receiver_address' => 'required|min:5',
        ];

        // Add service validation for service-to-service couriers
        if ($type === Courier::TYPE_SERVICE) {
            $rules['origin_service_id'] = 'required';
            $rules['destination_service_id'] = 'required';
        }

        $request->validate($rules);

        $courier = new Courier();
        $courier->tracking_number = Courier::generateTrackingNumber();
        $courier->type = $type;
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

        // Set service fields for service-to-service couriers
        if ($type === Courier::TYPE_SERVICE) {
            $courier->origin_service_id = $request->get('origin_service_id');
            $courier->destination_service_id = $request->get('destination_service_id');
            $courier->current_service_id = $request->get('origin_service_id'); // Initially at origin
        }

        $courier->save();

        // Create initial status history
        $comment = $type === Courier::TYPE_SERVICE
            ? 'Colis inter-service reçu et enregistré'
            : 'Colis reçu et enregistré';

        CourierStatusHistory::create([
            'courier_id' => $courier->id,
            'changed_by' => auth()->user()->id,
            'old_status' => null,
            'new_status' => Courier::STATUS_RECEIVED,
            'comment' => $comment
        ]);

        // Handle file uploads
        $this->handleFileUploads($request, $courier);

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

        $files = CourierFile::where('courier_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('agent.couriers.show', compact('courier', 'history', 'files'));
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

        $services = Service::where('is_active', true)->orderBy('name')->get();

        return view('agent.couriers.edit', compact('courier', 'services'));
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

    /**
     * Handle file uploads for courier
     *
     * @param Request $request
     * @param Courier $courier
     * @return void
     */
    protected function handleFileUploads(Request $request, Courier $courier): void
    {
        $files = $request->file('files');

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
        $existingCount = CourierFile::where('courier_id', $courier->id)->count();
        if ($existingCount + $fileCount > CourierFile::MAX_FILES_PER_COURIER) {
            return;
        }

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

            // Validate file
            $validationError = CourierFile::validateFile($file);
            if ($validationError !== null) {
                continue;
            }

            // Generate unique filename
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
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
                    'courier_id' => $courier->id,
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
     * Upload additional files to existing courier
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function uploadFiles(Request $request, int $id)
    {
        $user = auth()->user();
        $courier = Courier::where('id', $id)->where('agent_id', $user->id)->first();

        if (!$courier) {
            return redirect('/agent/couriers')->withFlash('error', 'Colis non trouvé');
        }

        $this->handleFileUploads($request, $courier);

        return redirect("/agent/couriers/{$id}")->withFlash('success', 'Fichiers ajoutés avec succès');
    }

    /**
     * Delete a file from courier
     *
     * @param Request $request
     * @param int $courierId
     * @param int $fileId
     * @return mixed
     */
    public function deleteFile(Request $request, int $courierId, int $fileId)
    {
        $user = app_auth()->user();

        $courier = Courier::where('id', $courierId)->where('agent_id', $user->id)->first();

        if (!$courier) {
            return redirect('/agent/couriers')->withFlash('error', 'Colis non trouvé');
        }

        $file = CourierFile::where('id', $fileId)->where('courier_id', $courierId)->first();

        if (!$file) {
            return redirect("/agent/couriers/{$courierId}")->withFlash('error', 'Fichier non trouvé');
        }

        // Delete physical files
        $storagePath = storage_path('couriers/' . $file->filename);
        $publicPath = public_path('storage/couriers/' . $file->filename);

        if (file_exists($storagePath)) {
            unlink($storagePath);
        }
        if (file_exists($publicPath)) {
            unlink($publicPath);
        }

        // Delete database record
        $file->delete();

        return redirect("/agent/couriers/{$courierId}")->withFlash('success', 'Fichier supprimé avec succès');
    }
}
