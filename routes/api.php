<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Admin\OrderController;
use App\Http\Controllers\API\Admin\DriverController;
use App\Http\Controllers\API\Admin\VehicleController;
use App\Http\Controllers\API\Admin\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Protected routes
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    // User profile
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Orders
    Route::apiResource('orders', OrderController::class);
    Route::get('/calendar', [OrderController::class, 'calendar']);
    Route::put('/orders/{order}/assign-driver', [OrderController::class, 'assignDriver']);
    Route::put('/orders/{order}/change-status', [OrderController::class, 'changeStatus']);

    // Drivers
    Route::apiResource('drivers', DriverController::class);

    // Armada/Vehicles
    Route::apiResource('vehicles', VehicleController::class);
    Route::post('/vehicles/upload-photo', [VehicleController::class, 'uploadPhoto']);

    // Payments
    Route::get('/payments', [PaymentController::class, 'index']);
    Route::post('/payments/complete', [PaymentController::class, 'completePayment']);
});
