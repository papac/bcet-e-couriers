<?php

namespace App\Controllers\Admin;

use App\Models\User;
use Bow\Http\Request;
use Bow\Support\Str;

class AgentController
{
    /**
     * List all agents
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
        
        $agents = $query->orderBy('created_at', 'desc')->get();
        
        return view('admin.agents.index', compact('agents', 'search'));
    }

    /**
     * Show create agent form
     *
     * @return string
     */
    public function create(): string
    {
        return view('admin.agents.create');
    }

    /**
     * Store new agent
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
            return redirect('/admin/agents/create')->withFlash('error', 'Cet email existe déjà');
        }

        $agent = new User();
        $agent->name = $request->get('name');
        $agent->email = $request->get('email');
        $agent->phone = $request->get('phone');
        $agent->password = app_hash($request->get('password'));
        $agent->role = 'agent';
        $agent->is_active = true;
        $agent->persist();

        return redirect('/admin/agents')->withFlash('success', 'Agent créé avec succès');
    }

    /**
     * Show edit agent form
     *
     * @param int $id
     * @return string
     */
    public function edit(int $id): string
    {
        $agent = User::where('id', $id)->where('role', 'agent')->first();
        
        if (!$agent) {
            return redirect('/admin/agents')->withFlash('error', 'Agent non trouvé');
        }

        return view('admin.agents.edit', compact('agent'));
    }

    /**
     * Update agent
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function update(Request $request, int $id)
    {
        $agent = User::where('id', $id)->where('role', 'agent')->first();
        
        if (!$agent) {
            return redirect('/admin/agents')->withFlash('error', 'Agent non trouvé');
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
            return redirect("/admin/agents/{$id}/edit")->withFlash('error', 'Cet email existe déjà');
        }

        $agent->name = $request->get('name');
        $agent->email = $request->get('email');
        $agent->phone = $request->get('phone');
        
        if ($request->get('password')) {
            $agent->password = app_hash($request->get('password'));
        }
        
        $agent->is_active = $request->get('is_active', false) ? true : false;
        $agent->persist();

        return redirect('/admin/agents')->withFlash('success', 'Agent mis à jour avec succès');
    }

    /**
     * Toggle agent status
     *
     * @param int $id
     * @return mixed
     */
    public function toggleStatus(int $id)
    {
        $agent = User::where('id', $id)->where('role', 'agent')->first();
        
        if (!$agent) {
            return redirect('/admin/agents')->withFlash('error', 'Agent non trouvé');
        }

        $agent->is_active = !$agent->is_active;
        $agent->save();

        $status = $agent->is_active ? 'activé' : 'désactivé';
        
        return redirect('/admin/agents')->withFlash('success', "Agent {$status} avec succès");
    }

    /**
     * Delete agent
     *
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        $agent = User::where('id', $id)->where('role', 'agent')->first();
        
        if (!$agent) {
            return redirect('/admin/agents')->withFlash('error', 'Agent non trouvé');
        }

        $agent->delete();

        return redirect('/admin/agents')->withFlash('success', 'Agent supprimé avec succès');
    }
}
