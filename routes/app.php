<?php

use App\Controllers\LoginController;
use App\Controllers\DashboardController;
use App\Controllers\CourierController;
use App\Controllers\UserController;
use App\Controllers\ServiceController;

// Authentication routes
$router->middleware(['guest'])->get('/login', LoginController::class)->name('auth.index');
$router->middleware(['guest', 'csrf', 'login.limit'])
    ->post('/login', [LoginController::class, 'login'])->name('auth.login');

$router->middleware(['auth:web'])->get('/logout', [LoginController::class, 'logout'])->name('auth.logout');

// App routes (authenticated users - both admin and agent)
$router->middleware(['auth:web'])->prefix('/app', function () use ($router) {
    // Dashboard
    $router->get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Courier management (all authenticated users)
    $router->get('/couriers', [CourierController::class, 'index'])->name('couriers.index');
    $router->get('/couriers/create', [CourierController::class, 'create'])->name('couriers.create');
    $router->post('/couriers', [CourierController::class, 'store'])->name('couriers.store');
    $router->get('/couriers/:id', [CourierController::class, 'show'])->name('couriers.show');
    $router->get('/couriers/:id/edit', [CourierController::class, 'edit'])->name('couriers.edit');
    $router->put('/couriers/:id', [CourierController::class, 'update'])->name('couriers.update');
    $router->put('/couriers/:id/status', [CourierController::class, 'updateStatus'])->name('couriers.status');

    // File management
    $router->post('/couriers/:id/files', [CourierController::class, 'uploadFiles'])->name('couriers.files.upload');
    $router->delete('/couriers/:courierId/files/:fileId', [CourierController::class, 'deleteFile'])->name('couriers.files.delete');

    // User management (admin only)
    $router->middleware(['admin'])->prefix('/users', function () use ($router) {
        $router->get('/', [UserController::class, 'index'])->name('users.index');
        $router->get('/create', [UserController::class, 'create'])->name('users.create');
        $router->post('/', [UserController::class, 'store'])->name('users.store');
        $router->get('/:id/edit', [UserController::class, 'edit'])->name('users.edit');
        $router->put('/:id', [UserController::class, 'update'])->name('users.update');
        $router->post('/:id/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle');
        $router->delete('/:id', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Service management (admin only)
    $router->middleware(['admin'])->prefix('/services', function () use ($router) {
        $router->get('/', [ServiceController::class, 'index'])->name('services.index');
        $router->get('/create', [ServiceController::class, 'create'])->name('services.create');
        $router->post('/', [ServiceController::class, 'store'])->name('services.store');
        $router->get('/:id/edit', [ServiceController::class, 'edit'])->name('services.edit');
        $router->put('/:id', [ServiceController::class, 'update'])->name('services.update');
        $router->post('/:id/toggle-status', [ServiceController::class, 'toggleStatus'])->name('services.toggle');
        $router->delete('/:id', [ServiceController::class, 'destroy'])->name('services.destroy');
    });
});
