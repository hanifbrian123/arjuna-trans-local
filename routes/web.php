<?php
use Illuminate\Support\Facades\{Route, Auth};
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Driver\OrderController as DriverOrderController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;

Route::get('/', function () {
    return view('frontpage.landing');
})->name('landing');

Auth::routes(['register' => false, 'verify' => false]);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Order Management
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [AdminOrderController::class, 'index'])->name('index');
            Route::get('/calendar', [AdminOrderController::class, 'calendar'])->name('calendar');
            Route::get('/create', [AdminOrderController::class, 'create'])->name('create');
            Route::post('/', [AdminOrderController::class, 'store'])->name('store');
            Route::get('/{order}/edit', [AdminOrderController::class, 'edit'])->name('edit');
            Route::put('/{order}', [AdminOrderController::class, 'update'])->name('update');
            Route::delete('/{order}', [AdminOrderController::class, 'destroy'])->name('destroy');
            Route::get('/{order}/detail', [AdminOrderController::class, 'detail'])->name('detail');
        });

        // Driver Management
        Route::prefix('drivers')->name('drivers.')->group(function () {
            Route::get('/', [DriverController::class, 'index'])->name('index');
            Route::get('/create', [DriverController::class, 'create'])->name('create');
            Route::post('/', [DriverController::class, 'store'])->name('store');
            Route::get('/{driver}', [DriverController::class, 'show'])->name('show');
            Route::get('/{driver}/edit', [DriverController::class, 'edit'])->name('edit');
            Route::put('/{driver}', [DriverController::class, 'update'])->name('update');
            Route::delete('/{driver}', [DriverController::class, 'destroy'])->name('destroy');
        });

        // Armada/Vehicle Management
        Route::prefix('vehicles')->name('vehicles.')->group(function () {
            Route::get('/', [AdminVehicleController::class, 'index'])->name('index');
            Route::get('/create', [AdminVehicleController::class, 'create'])->name('create');
            Route::post('/', [AdminVehicleController::class, 'store'])->name('store');
            Route::get('/{vehicle}', [AdminVehicleController::class, 'show'])->name('show');
            Route::get('/{vehicle}/edit', [AdminVehicleController::class, 'edit'])->name('edit');
            Route::put('/{vehicle}', [AdminVehicleController::class, 'update'])->name('update');
            Route::delete('/{vehicle}', [AdminVehicleController::class, 'destroy'])->name('destroy');
        });

        // Payment Reports
        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/', [PaymentController::class, 'index'])->name('index');
            Route::post('/complete', [PaymentController::class, 'complete'])->name('complete');
        });
    });

    // Driver Routes
    Route::middleware(['role:driver'])->prefix('driver')->name('driver.')->group(function () {
        // Order Management for Drivers
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [DriverOrderController::class, 'index'])->name('index');
            Route::get('/calendar', [DriverOrderController::class, 'calendar'])->name('calendar');
            Route::get('/create', [DriverOrderController::class, 'create'])->name('create');
            Route::post('/', [DriverOrderController::class, 'store'])->name('store');
            Route::get('/{order}/edit', [DriverOrderController::class, 'edit'])->name('edit');
            Route::put('/{order}', [DriverOrderController::class, 'update'])->name('update');
            Route::get('/{order}/detail', [DriverOrderController::class, 'detail'])->name('detail');
        });


    });
});

Route::fallback(fn() => view('errors.404'));
