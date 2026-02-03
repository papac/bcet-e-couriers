<?php

namespace App\Controllers;

use App\Controllers\Admin\CourierController as AdminCourierController;
use App\Controllers\Agent\CourierController as AgentCourierController;
use Bow\Http\Request;

class CourierController
{
    /**
     * Get the appropriate controller based on user role
     *
     * @return AdminCourierController|AgentCourierController
     */
    protected function getController(): AdminCourierController|AgentCourierController
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return new AdminCourierController();
        }

        return new AgentCourierController();
    }

    /**
     * List couriers
     *
     * @param Request $request
     * @return string
     */
    public function index(Request $request): string
    {
        return $this->getController()->index($request);
    }

    /**
     * Show create courier form
     *
     * @return string
     */
    public function create(): string
    {
        return $this->getController()->create();
    }

    /**
     * Store new courier
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->getController()->store($request);
    }

    /**
     * Show courier details
     *
     * @param int $id
     * @return string
     */
    public function show(int $id): string
    {
        return $this->getController()->show($id);
    }

    /**
     * Show edit courier form
     *
     * @param int $id
     * @return string
     */
    public function edit(int $id): string
    {
        return $this->getController()->edit($id);
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
        return $this->getController()->update($request, $id);
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
        return $this->getController()->updateStatus($request, $id);
    }

    /**
     * Upload files to courier
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function uploadFiles(Request $request, int $id)
    {
        return $this->getController()->uploadFiles($request, $id);
    }

    /**
     * Delete courier file
     *
     * @param Request $request
     * @param int $courierId
     * @param int $fileId
     * @return mixed
     */
    public function deleteFile(Request $request, int $courierId, int $fileId)
    {
        return $this->getController()->deleteFile($request, $courierId, $fileId);
    }
}
