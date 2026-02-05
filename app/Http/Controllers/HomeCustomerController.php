<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class HomeCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function formCust()
    {
        $vehicles = Vehicle::where('status', 'ready')->get();
        $drivers = Driver::where('status', 'active')->get();

        return view('frontpage.landing', compact('vehicles', 'drivers'));
    }

    public function calendar(Request $request)
    {

        $vehicles = Vehicle::where('status', 'ready')->get();
        $drivers = Driver::where('status', 'active')->get();

        if ($request->wantsJson() || $request->ajax()) {
            try {
                // Only include approved orders for calendar view
                $query = Order::where('status', 'approved');

                // Apply filters if provided
                if ($request->has('driver_id') && $request->driver_id) {
                    $query->where('driver_id', $request->driver_id);
                }

                if ($request->has('vehicle_type') && $request->vehicle_type) {
                    $query->where('vehicle_type', $request->vehicle_type);
                }

                // Filter by date range if provided
                if ($request->has('start') && $request->has('end')) {
                    $query->where(function ($q) use ($request) {
                        $q->whereBetween('start_date', [$request->start, $request->end])
                            ->orWhereBetween('end_date', [$request->start, $request->end])
                            ->orWhere(function ($q2) use ($request) {
                                $q2->where('start_date', '<=', $request->start)
                                    ->where('end_date', '>=', $request->end);
                            });
                    });
                }

                $orders = $query->get();
                $events = [];

                // Define a wide range of vibrant colors for better distinction
                $colorPalette = [
                    '#4285F4', // bright blue
                    '#EA4335', // bright red
                    '#9C27B0', // purple
                    '#34A853', // green
                    '#FBBC05', // yellow/amber
                    '#FF5722', // deep orange
                    '#00BCD4', // cyan
                    '#795548', // brown
                    '#607D8B', // blue grey
                    '#E91E63', // pink
                    '#3F51B5', // indigo
                    '#009688', // teal
                    '#FF9800', // orange
                    '#8BC34A', // light green
                    '#FFC107', // amber
                    '#03A9F4', // light blue
                    '#673AB7', // deep purple
                    '#CDDC39', // lime
                    '#2196F3', // blue
                    '#F44336'  // red
                ];

                // Define specific colors for common vehicle types
                $vehicleColors = [
                    'NKR 55 LWB' => '#4285F4',           // bright blue
                    'HINO MDBL' => '#FBBC05',             // bright red
                    'HINO FB' => '#34A853',             // purple
                    'Avanza' => '#34A853',          // green
                    'Innova' => '#FBBC05'           // yellow/amber
                ];

                // Additional colors for other vehicle types
                $additionalColors = [
                    '#3788d8',
                    '#FF5722',
                    '#00BCD4',
                    '#795548',
                    '#607D8B',
                    '#E91E63',
                    '#3F51B5',
                    '#009688',
                    '#8BC34A',
                    '#FFC107'
                ];

                foreach ($orders as $order) {
                    // Set color based on vehicle type
                    $color = '#3788d8'; // Default blue

                    // Try to match vehicle type to a color
                    foreach ($vehicleColors as $vehicleName => $vehicleColor) {
                        if (stripos($order->vehicle_type, $vehicleName) !== false) {
                            $color = $vehicleColor;
                            break;
                        }
                    }

                    // Format title to be more readable and informative
                    $title = $order->vehicle_type;

                    // Add destination if available
                    if (strlen($order->destination) > 0) {
                        $title .= ' → ' . $order->destination;
                    }

                    // Add driver name if available
                    if (!empty($order->driver_name)) {
                        $title .= ' (' . $order->driver_name . ')';
                    }

                    // Add order number for better identification
                    if (!empty($order->order_num)) {
                        $title = '[' . $order->order_num . '] ' . $title;
                    }

                    $events[] = [
                        'id' => $order->id,
                        'title' => $title,
                        'start' => $order->start_date->format('Y-m-d H:i:s'),
                        'end' => $order->end_date->format('Y-m-d H:i:s'),
                        'color' => $color,
                        'className' => 'event-' . $order->status,
                        'extendedProps' => [
                            'customer' => $order->name,
                            'phone' => $order->phone_number,
                            'destination' => $order->destination,
                            'vehicle_type' => $order->vehicle_type,
                            'driver_name' => $order->driver_name,
                            'pickup' => $order->pickup_address,
                            'status' => $order->status
                        ]
                    ];
                }
                // return $events;

                return response()->json($events);
            } catch (\Exception $e) {
                // Return a proper JSON error response
                return response()->json(['error' => 'Failed to load events: ' . $e->getMessage()], 500);
            }
        }

        return view('frontpage.calendar', compact('drivers', 'vehicles'));
    }

    public function detail(Order $order)
    {                
        // Load relationships
        $order->load(['vehicles', 'drivers']);

        return response()->json($order);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function saveCust(Request $request)
    {
        // return $request;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'pickup_address' => 'required|string|max:500',
            'destination' => 'required|string|max:255',
            'route' => 'required|string|max:1000',
            'vehicle_ids' => 'required|array',
            'vehicle_ids.*' => 'exists:vehicles,id',
            'driver_ids' => 'required|array',
            'driver_ids.*' => 'exists:drivers,id',
        ], [
            'vehicle_count.max' => 'Jumlah armada maksimal 10 unit.',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
            'vehicle_ids.required' => 'Pilih minimal satu armada.',
            'driver_ids.required' => 'Pilih minimal satu driver.',
        ]);

        $validated['rental_price'] = 0;
        $validated['down_payment'] = 0;
        $validated['remaining_cost'] = 0;

        // Get the first driver for backward compatibility
        $primaryDriver = Driver::find($validated['driver_ids'][0]);
        $validated['driver_id'] = $primaryDriver->id;
        $validated['driver_name'] = $primaryDriver->user->name;

        // Get the first vehicle's type for the vehicle_type field
        $primaryVehicle = Vehicle::find($validated['vehicle_ids'][0]);
        $validated['vehicle_type'] = $primaryVehicle->type;

        // Generate order number (format: ORD-YYYYMMDD-XXX)
        $date = now()->format('Ymd');
        $lastOrder = Order::whereDate('created_at', now())->latest()->first();
        $lastNumber = 0;

        if ($lastOrder && $lastOrder->order_num) {
            $parts = explode('-', $lastOrder->order_num);
            if (count($parts) == 3 && $parts[1] == $date) {
                $lastNumber = (int) $parts[2];
            }
        }

        $newNumber = $lastNumber + 1;
        $validated['order_num'] = 'ORD-' . $date . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        $order = Order::create($validated);
        $order->vehicles()->attach($validated['vehicle_ids']);
        $order->drivers()->attach($validated['driver_ids']);
        return redirect(url('customer'))->with('success', 'Pesanan Anda berhasil dibuat!');
    }
}
