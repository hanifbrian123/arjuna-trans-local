<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VehicleController;

//Public routes

Route::get('/', function () {
    return view('frontpage.landing');
})->name('landing');


//Authentication routes
Auth::routes(['register' => false, 'verify' => false]);

//Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Dashboard routes - accessible by all authenticated users
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Order routes with role-based access
    Route::prefix('orders')->group(function () {
        // Routes accessible by customers
        Route::middleware(['role:customer'])->group(function () {
            Route::get('/create', [OrderController::class, 'create'])->name('orders.create');
            Route::post('/', [OrderController::class, 'store'])->name('orders.store');
        });

        // Routes accessible by customers and drivers
        Route::middleware(['role:customer|driver'])->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('orders.index');
            Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');
        });

        // Routes accessible by drivers only
        Route::middleware(['role:driver'])->group(function () {
            Route::put('/{order}/accept', [OrderController::class, 'accept'])->name('orders.accept');
            Route::put('/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');
        });

        // Routes accessible by admin only
        Route::middleware(['role:admin'])->group(function () {
            Route::get('/all', [OrderController::class, 'adminIndex'])->name('orders.admin.index');
            Route::delete('/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
        });
    });

    // Vehicle routes with role-based access
    Route::prefix('vehicles')->group(function () {
        // Routes accessible by admin and drivers
        Route::middleware(['role:admin|driver'])->group(function () {
            Route::get('/', [VehicleController::class, 'index'])->name('vehicles.index');
        });

        // Routes accessible by admin only
        Route::middleware(['role:admin'])->group(function () {
            Route::get('/create', [VehicleController::class, 'create'])->name('vehicles.create');
            Route::post('/', [VehicleController::class, 'store'])->name('vehicles.store');
            Route::get('/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
            Route::put('/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
            Route::delete('/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');
            Route::post('/upload-photo', [VehicleController::class, 'uploadPhoto'])->name('vehicles.upload-photo');
        });

        // This route needs to be after the specific routes to avoid conflicts
        Route::middleware(['role:admin|driver'])->group(function () {
            Route::get('/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');
        });
    });
});

//Fallback route for 404
Route::fallback(fn() => view('errors.404'));
