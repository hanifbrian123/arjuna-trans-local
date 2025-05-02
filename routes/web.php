<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
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

    // Booking routes with role-based access
    Route::prefix('bookings')->group(function () {
        // Routes accessible by customers
        Route::middleware(['role:customer'])->group(function () {
            Route::get('/create', [BookingController::class, 'create'])->name('bookings.create');
            Route::post('/', [BookingController::class, 'store'])->name('bookings.store');
        });

        // Routes accessible by customers and drivers
        Route::middleware(['role:customer|driver'])->group(function () {
            Route::get('/', [BookingController::class, 'index'])->name('bookings.index');
            Route::get('/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        });

        // Routes accessible by drivers only
        Route::middleware(['role:driver'])->group(function () {
            Route::put('/{booking}/accept', [BookingController::class, 'accept'])->name('bookings.accept');
            Route::put('/{booking}/complete', [BookingController::class, 'complete'])->name('bookings.complete');
        });

        // Routes accessible by admin only
        Route::middleware(['role:admin'])->group(function () {
            Route::get('/all', [BookingController::class, 'adminIndex'])->name('bookings.admin.index');
            Route::delete('/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
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

    // Admin specific routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/reports', [DashboardController::class, 'reports'])->name('admin.reports');
        Route::get('/settings', [DashboardController::class, 'settings'])->name('admin.settings');
    });
});

//Fallback route for 404
Route::fallback(fn() => view('errors.404'));
