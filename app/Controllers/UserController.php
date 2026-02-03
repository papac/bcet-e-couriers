<?php

namespace App\Controllers;

use App\Enums\AppAccess;
use App\Models\User;
use App\Models\Service;
use Bow\Http\Request;

class UserController
{
    /**
     * List all users (agents)
     *
     * @param Request $request
     * @return string
     */
    public function index(Request $request): string
    {
        $search = $request->get('search');

        $query = User::where('role', 'agent');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        return view('admin.users.index', compact('users', 'search'));
    }

    /**
     * Show create user form
     *
     * @return string
     */
    public function create(): string
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();
        $availableApps = User::getAvailableApps();
        return view('admin.users.create', compact('services', 'availableApps'));
    }

    /**
     * Store new user
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:100',
            'email' => 'required|email',
            'phone' => 'required|min:8',
            'password' => 'required|min:6'
        ]);

        // Check if email already exists
        if (User::where('email', $request->get('email'))->exists()) {
            return redirect('/app/users/create')->withFlash('error', 'Cet email existe déjà');
        }

        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->phone = $request->get('phone');
        $user->password = app_hash($request->get('password'));
        $user->role = 'agent';
        $user->is_active = true;
        $user->service_id = $request->get('service_id') ?: null;

        // Set app access
        $appAccess = $request->get('app_access', []);
        if (is_array($appAccess)) {
            $user->app_access = implode(',', $appAccess);
        } else {
            $user->app_access = $appAccess ?: AppAccess::COURRIER->value;
        }

        $user->persist();

        return redirect('/app/users')->withFlash('success', 'Utilisateur créé avec succès');
    }

    /**
     * Show edit user form
     *
     * @param int $id
     * @return string
     */
    public function edit(int $id): string
    {
        $user = User::where('id', $id)->where('role', 'agent')->first();

        if (!$user) {
            return redirect('/app/users')->withFlash('error', 'Utilisateur non trouvé');
        }

        $services = Service::where('is_active', true)->orderBy('name')->get();
        $availableApps = User::getAvailableApps();
        return view('admin.users.edit', compact('user', 'services', 'availableApps'));
    }

    /**
     * Update user
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function update(Request $request, int $id)
    {
        $user = User::where('id', $id)->where('role', 'agent')->first();

        if (!$user) {
            return redirect('/app/users')->withFlash('error', 'Utilisateur non trouvé');
        }

        $request->validate([
            'name' => 'required|min:2|max:100',
            'email' => 'required|email',
            'phone' => 'required|min:8'
        ]);

        // Check if email already exists for another user
        $existingUser = User::where('email', $request->get('email'))
            ->where('id', '!=', $id)
            ->first();

        if ($existingUser) {
            return redirect("/app/users/{$id}/edit")->withFlash('error', 'Cet email existe déjà');
        }

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->phone = $request->get('phone');
        $user->service_id = $request->get('service_id') ?: null;

        if ($request->get('password')) {
            $user->password = app_hash($request->get('password'));
        }

        $user->is_active = $request->get('is_active', false) ? true : false;

        // Set app access
        $appAccess = $request->get('app_access', []);
        if (is_array($appAccess)) {
            $user->app_access = implode(',', $appAccess);
        } else {
            $user->app_access = $appAccess ?: '';
        }

        $user->persist();

        return redirect('/app/users')->withFlash('success', 'Utilisateur mis à jour avec succès');
    }

    /**
     * Toggle user status
     *
     * @param int $id
     * @return mixed
     */
    public function toggleStatus(int $id)
    {
        $user = User::where('id', $id)->where('role', 'agent')->first();

        if (!$user) {
            return redirect('/app/users')->withFlash('error', 'Utilisateur non trouvé');
        }

        $user->is_active = !$user->is_active;
        $user->persist();

        $status = $user->is_active ? 'activé' : 'désactivé';
        return redirect('/app/users')->withFlash('success', "Utilisateur {$status} avec succès");
    }

    /**
     * Delete user
     *
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        $user = User::where('id', $id)->where('role', 'agent')->first();

        if (!$user) {
            return redirect('/app/users')->withFlash('error', 'Utilisateur non trouvé');
        }

        // Prevent deleting yourself
        if ($user->id === auth()->user()->id) {
            return redirect('/app/users')->withFlash('error', 'Vous ne pouvez pas supprimer votre propre compte');
        }

        $user->delete();

        return redirect('/app/users')->withFlash('success', 'Utilisateur supprimé avec succès');
    }
}
