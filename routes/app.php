<?php

use App\Controllers\WelcomeController;
use App\Controllers\Auth\LoginController;
use App\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Controllers\Admin\AgentController;
use App\Controllers\Admin\CourierController as AdminCourierController;
use App\Controllers\Agent\DashboardController as AgentDashboardController;
use App\Controllers\Agent\CourierController as AgentCourierController;

// Public routes
$router->get('/', WelcomeController::class)->name('app.index');

// Authentication routes
$router->get('/login', [LoginController::class, 'showLoginForm'])->name('auth.login');
$router->middleware(['csrf', 'login.limit'])->post('/login', [LoginController::class, 'login'])->name('auth.login.post');
$router->get('/logout', [LoginController::class, 'logout'])->name('auth.logout');

// Admin routes
$router->middleware(['auth', 'admin'])->prefix('/admin', function () use ($router) {
    // Dashboard
    $router->get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Agent management
    $router->get('/agents', [AgentController::class, 'index'])->name('admin.agents.index');
    $router->get('/agents/create', [AgentController::class, 'create'])->name('admin.agents.create');
    $router->post('/agents', [AgentController::class, 'store'])->name('admin.agents.store');
    $router->get('/agents/:id/edit', [AgentController::class, 'edit'])->name('admin.agents.edit');
    $router->put('/agents/:id', [AgentController::class, 'update'])->name('admin.agents.update');
    $router->post('/agents/:id/toggle-status', [AgentController::class, 'toggleStatus'])->name('admin.agents.toggle');
    $router->delete('/agents/:id', [AgentController::class, 'destroy'])->name('admin.agents.destroy');

    // Courier management (view all)
    $router->get('/couriers', [AdminCourierController::class, 'index'])->name('admin.couriers.index');
    $router->get('/couriers/:id', [AdminCourierController::class, 'show'])->name('admin.couriers.show');
    $router->put('/couriers/:id/status', [AdminCourierController::class, 'updateStatus'])->name('admin.couriers.status');
});

// Agent routes
$router->middleware(['auth', 'agent'])->prefix('/agent', function () use ($router) {
    // Dashboard
    $router->get('/', [AgentDashboardController::class, 'index'])->name('agent.dashboard');
    
    // Courier management
    $router->get('/couriers', [AgentCourierController::class, 'index'])->name('agent.couriers.index');
    $router->get('/couriers/create', [AgentCourierController::class, 'create'])->name('agent.couriers.create');
    $router->post('/couriers', [AgentCourierController::class, 'store'])->name('agent.couriers.store');
    $router->get('/couriers/:id', [AgentCourierController::class, 'show'])->name('agent.couriers.show');
    $router->get('/couriers/:id/edit', [AgentCourierController::class, 'edit'])->name('agent.couriers.edit');
    $router->put('/couriers/:id', [AgentCourierController::class, 'update'])->name('agent.couriers.update');
    $router->put('/couriers/:id/status', [AgentCourierController::class, 'updateStatus'])->name('agent.couriers.status');
    
    // File management
    $router->post('/couriers/:id/files', [AgentCourierController::class, 'uploadFiles'])->name('agent.couriers.files.upload');
    $router->delete('/couriers/:courierId/files/:fileId', [AgentCourierController::class, 'deleteFile'])->name('agent.couriers.files.delete');
});
