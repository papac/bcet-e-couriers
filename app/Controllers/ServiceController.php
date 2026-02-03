<?php

namespace App\Controllers;

use App\Models\Service;
use App\Models\User;
use Bow\Http\Request;

class ServiceController
{
    /**
     * List all services
     *
     * @param Request $request
     * @return string
     */
    public function index(Request $request): string
    {
        $search = $request->get('search');

        $query = Service::query();

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('code', 'LIKE', "%{$search}%")
                ->orWhere('city', 'LIKE', "%{$search}%");
        }

        $services = $query->orderBy('name', 'asc')->get();

        return view('admin.services.index', compact('services', 'search'));
    }

    /**
     * Show create service form
     *
     * @return string
     */
    public function create(): string
    {
        $agents = User::where('is_active', true)->orderBy('name')->get();
        return view('admin.services.create', compact('agents'));
    }

    /**
     * Store new service
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:100',
            'city' => 'required|min:2',
        ]);

        $service = new Service();
        $service->name = $request->get('name');
        $service->code = Service::generateCode($request->get('name'));
        $service->address = $request->get('address');
        $service->city = $request->get('city');
        $service->phone = $request->get('phone');
        $service->email = $request->get('email');
        $service->chief_id = $request->get('chief_id') ?: null;
        $service->is_active = true;
        $service->save();

        return redirect('/app/services')->withFlash('success', "Service '{$service->name}' créé avec succès");
    }

    /**
     * Show edit service form
     *
     * @param int $id
     * @return string
     */
    public function edit(int $id): string
    {
        $service = Service::find($id);

        if (!$service) {
            return redirect('/app/services')->withFlash('error', 'Service non trouvé');
        }

        $agents = User::where('is_active', true)->orderBy('name')->get();
        return view('admin.services.edit', compact('service', 'agents'));
    }

    /**
     * Update service
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function update(Request $request, int $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return redirect('/app/services')->withFlash('error', 'Service non trouvé');
        }

        $request->validate([
            'name' => 'required|min:2|max:100',
            'city' => 'required|min:2',
        ]);

        $service->name = $request->get('name');
        $service->address = $request->get('address');
        $service->city = $request->get('city');
        $service->phone = $request->get('phone');
        $service->email = $request->get('email');
        $service->chief_id = $request->get('chief_id') ?: null;
        $service->is_active = $request->get('is_active') ? true : false;
        $service->save();

        return redirect('/app/services')->withFlash('success', 'Service mis à jour avec succès');
    }

    /**
     * Toggle service active status
     *
     * @param int $id
     * @return mixed
     */
    public function toggleStatus(int $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return redirect('/app/services')->withFlash('error', 'Service non trouvé');
        }

        $service->is_active = !$service->is_active;
        $service->save();

        $status = $service->is_active ? 'activé' : 'désactivé';
        return redirect('/app/services')->withFlash('success', "Service {$status} avec succès");
    }

    /**
     * Delete service
     *
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return redirect('/app/services')->withFlash('error', 'Service non trouvé');
        }

        // Check if service has associated users
        $usersCount = User::where('service_id', $id)->count();
        if ($usersCount > 0) {
            return redirect('/app/services')->withFlash('error', "Impossible de supprimer: {$usersCount} utilisateur(s) associé(s)");
        }

        $service->delete();

        return redirect('/app/services')->withFlash('success', 'Service supprimé avec succès');
    }
}
