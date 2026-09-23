<?php

use App\Controllers\LoginController;
use App\Controllers\DashboardController;
use App\Controllers\Admin\CourierController as AdminCourierController;
use App\Controllers\Agent\CourierController as AgentCourierController;
use App\Controllers\UserController;
use App\Controllers\ServiceController;

/**@var Bow\Router\Router $router */

// Middleware stacks
$agent = ['auth:web', 'agent', 'app.access:couriers'];
$admin = ['auth:web', 'admin'];

// Authentication routes
$router->middleware(['guest'])
    ->get('/login', LoginController::class)
    ->name('auth.index');

$router->middleware(['guest', 'csrf', 'login.limit'])
    ->post('/login', [LoginController::class, 'login'])
    ->name('auth.login');

$router->middleware(['auth:web'])
    ->get('/logout', [LoginController::class, 'logout'])
    ->name('auth.logout');

// Dashboard - app selection
$router->middleware(['auth:web'])
    ->get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

// ============================================
// COURIERS APP (agent) - /couriers
// ============================================
$router->middleware($agent)
    ->get('/couriers', [AgentCourierController::class, 'index'])
    ->name('couriers.index');

$router->middleware($agent)
    ->get('/couriers/create', [AgentCourierController::class, 'create'])
    ->name('couriers.create');

$router->middleware($agent)
    ->post('/couriers', [AgentCourierController::class, 'store'])
    ->name('couriers.store');

$router->middleware($agent)
    ->get('/couriers/:id', [AgentCourierController::class, 'show'])
    ->name('couriers.show');

$router->middleware($agent)
    ->get('/couriers/:id/edit', [AgentCourierController::class, 'edit'])
    ->name('couriers.edit');

$router->middleware($agent)
    ->put('/couriers/:id', [AgentCourierController::class, 'update'])
    ->name('couriers.update');

$router->middleware($agent)
    ->put('/couriers/:id/status', [AgentCourierController::class, 'updateStatus'])
    ->name('couriers.status');

// File management
$router->middleware($agent)
    ->post('/couriers/:id/files', [AgentCourierController::class, 'uploadFiles'])
    ->name('couriers.files.upload');

$router->middleware($agent)
    ->delete('/couriers/:courierId/files/:fileId', [AgentCourierController::class, 'deleteFile'])
    ->name('couriers.files.delete');

// ============================================
// COURIERS APP (admin) - /admin/couriers
// ============================================
$router->middleware($admin)
    ->get('/admin/couriers', [AdminCourierController::class, 'index'])
    ->name('admin.couriers.index');

// Réception de courrier (incoming)
$router->middleware($admin)
    ->get('/admin/couriers/incoming/create', [AdminCourierController::class, 'createIncoming'])
    ->name('admin.couriers.incoming.create');

// Départ de courrier (outgoing)
$router->middleware($admin)
    ->get('/admin/couriers/outgoing/create', [AdminCourierController::class, 'createOutgoing'])
    ->name('admin.couriers.outgoing.create');

$router->middleware($admin)
    ->post('/admin/couriers', [AdminCourierController::class, 'store'])
    ->name('admin.couriers.store');

$router->middleware($admin)
    ->get('/admin/couriers/:id', [AdminCourierController::class, 'show'])
    ->name('admin.couriers.show');

$router->middleware($admin)
    ->get('/admin/couriers/:id/edit', [AdminCourierController::class, 'edit'])
    ->name('admin.couriers.edit');

$router->middleware($admin)
    ->put('/admin/couriers/:id', [AdminCourierController::class, 'update'])
    ->name('admin.couriers.update');

$router->middleware($admin)
    ->put('/admin/couriers/:id/status', [AdminCourierController::class, 'updateStatus'])
    ->name('admin.couriers.status');

// ============================================
// RECOVERIES APP - /recoveries
// ============================================
// $router->middleware(['auth:web', 'app.access:recoveries'])
//     ->get('/recoveries', [RecouvrementController::class, 'index'])
//     ->name('recoveries.index');

// ============================================
// ADMIN ONLY - User & Service Management
// ============================================
// User management
$router->middleware($admin)
    ->get('/admin/users', [UserController::class, 'index'])
    ->name('users.index');

$router->middleware($admin)
    ->get('/admin/users/create', [UserController::class, 'create'])
    ->name('users.create');

$router->middleware($admin)
    ->post('/admin/users', [UserController::class, 'store'])
    ->name('users.store');

$router->middleware($admin)
    ->get('/admin/users/:id/edit', [UserController::class, 'edit'])
    ->name('users.edit');

$router->middleware($admin)
    ->put('/admin/users/:id', [UserController::class, 'update'])
    ->name('users.update');

$router->middleware($admin)
    ->post('/admin/users/:id/toggle-status', [UserController::class, 'toggleStatus'])
    ->name('users.toggle');

$router->middleware($admin)
    ->delete('/admin/users/:id', [UserController::class, 'destroy'])
    ->name('users.destroy');

// Service management
$router->middleware($admin)
    ->get('/admin/services', [ServiceController::class, 'index'])
    ->name('services.index');

$router->middleware($admin)
    ->get('/admin/services/create', [ServiceController::class, 'create'])
    ->name('services.create');

$router->middleware($admin)
    ->post('/admin/services', [ServiceController::class, 'store'])
    ->name('services.store');

$router->middleware($admin)
    ->get('/admin/services/:id/edit', [ServiceController::class, 'edit'])
    ->name('services.edit');

$router->middleware($admin)
    ->put('/admin/services/:id', [ServiceController::class, 'update'])
    ->name('services.update');

$router->middleware($admin)
    ->post('/admin/services/:id/toggle-status', [ServiceController::class, 'toggleStatus'])
    ->name('services.toggle');

$router->middleware($admin)
    ->delete('/admin/services/:id', [ServiceController::class, 'destroy'])
    ->name('services.destroy');
