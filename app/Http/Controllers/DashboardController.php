<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Check user role and redirect accordingly
        if (auth()->user()->hasRole('admin')) {
            return $this->adminDashboard();
        } elseif (auth()->user()->hasRole('driver')) {
            return $this->driverDashboard();
        } else {
            // Fallback for unknown roles
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke sistem.');
        }
    }

    private function adminDashboard()
    {
        // Count orders with 'waiting' status
        $orderWaiting = Order::where('status', 'waiting')->count();

        // Count all vehicles
        $armadaCount = Vehicle::count();

        // Count all drivers
        $driverCount = Driver::count();

        // Count all expenses
        $expensesCount = Expense::count();

        $financeReportCount = $expensesCount + $orderWaiting + Order::where('status', 'approved')->count();

        // Count orders that are currently active (between start and end date)
        $onTripCount = Order::where('status', 'approved')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->count();

        return view('dashboard.admin', compact('orderWaiting', 'armadaCount', 'driverCount', 'onTripCount', 'expensesCount', 'financeReportCount'));
    }

    private function driverDashboard()
    {
        // Get the current driver
        $driver = auth()->user()->driver;

        if (!$driver) {
            return redirect()->route('login')->with('error', 'Profil driver tidak ditemukan.');
        }

        // Count orders assigned to this driver with different statuses
        $waitingOrders = Order::where('status', 'waiting')->whereNull('driver_id')->count();
        $approvedOrders = Order::where('status', 'approved')->where('driver_id', $driver->id)->count();
        $completedOrders = 0;

        // Count orders that are currently active for this driver
        $onTripCount = Order::where('status', 'approved')
            ->where('driver_id', $driver->id)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->count();

        // Get upcoming trips (next 7 days)
        $upcomingTrips = Order::where('status', 'approved')
            ->where('driver_id', $driver->id)
            ->whereDate('start_date', '>', now())
            ->whereDate('start_date', '<=', now()->addDays(7))
            ->orderBy('start_date')
            ->get();

        return view('dashboard.driver', compact('waitingOrders', 'approvedOrders', 'completedOrders', 'onTripCount', 'upcomingTrips'));
    }
}
