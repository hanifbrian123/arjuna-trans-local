<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Order;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->datatables();
        }

        $vehicles = Vehicle::where('status', 'ready')->get();
        $drivers = Driver::where('status', 'active')->get();
        return view('admin.orders.index', compact('vehicles', 'drivers'));
    }

    public function calendar(Request $request)
    {
        // Get all drivers and vehicles for filters
        $drivers = Driver::where('status', 'active')->get();
        $vehicles = Vehicle::where('status', 'ready')->get();

        // Check if this is an AJAX request for events
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

                // Define vehicle colors - using vibrant colors for better distinction
                $vehicleColors = [
                    'Arjuna Trans 01' => '#4285F4', // bright blue
                    'Arjuna Trans 02' => '#EA4335', // bright red
                    'Arjuna Trans 03' => '#9C27B0', // purple
                    'Arjuna Trans 04' => '#34A853', // green
                    'Arjuna Trans 05' => '#FBBC05', // yellow/amber
                    'Hiace' => '#4285F4',           // bright blue
                    'Elf' => '#EA4335',             // bright red
                    'Bus' => '#9C27B0',             // purple
                    'Avanza' => '#34A853',          // green
                    'Innova' => '#FBBC05'           // yellow/amber
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

                    // Format title to be more readable
                    $title = $order->vehicle_type;
                    if (strlen($order->destination) > 0) {
                        $title .= ' → ' . $order->destination;
                    }

                    $events[] = [
                        'id' => $order->id,
                        'title' => $title,
                        'start' => $order->start_date->format('Y-m-d H:i:s'),
                        'end' => $order->end_date->format('Y-m-d H:i:s'),
                        'color' => $color,
                        'url' => route('admin.orders.show', $order->id),
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

                return response()->json($events);
            } catch (\Exception $e) {
                // Return a proper JSON error response
                return response()->json(['error' => 'Failed to load events: ' . $e->getMessage()], 500);
            }
        }

        return view('admin.orders.calendar', compact('drivers', 'vehicles'));
    }

    /**
     * Convert hex color to rgba
     *
     * @param string $hex Hex color code
     * @param float $opacity Opacity value (0-1)
     * @return string RGBA color string
     */
    private function hexToRgba($hex, $opacity = 1)
    {
        $hex = str_replace('#', '', $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }

        return "rgba($r, $g, $b, $opacity)";
    }

    public function datatables()
    {
        $query = Order::query();

        // Apply filters from request
        $request = request();

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->has('date') && $request->date) {
            $date = $request->date;
            $query->whereDate('start_date', '<=', $date)
                ->whereDate('end_date', '>=', $date);
        }

        // Filter by vehicle type
        if ($request->has('vehicle_type') && $request->vehicle_type) {
            $query->where('vehicle_type', $request->vehicle_type);
        }

        // Filter by driver
        if ($request->has('driver_id') && $request->driver_id) {
            $query->where('driver_id', $request->driver_id);
        }

        $orders = $query->get();

        return DataTables::of($orders)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                $statusClass = '';
                $statusText = $row->status;

                if ($row->status == 'waiting') {
                    $statusClass = 'badge bg-warning';
                    $statusText = 'Menunggu';
                } elseif ($row->status == 'approved') {
                    $statusClass = 'badge bg-success';
                    $statusText = 'Disetujui';
                } elseif ($row->status == 'canceled') {
                    $statusClass = 'badge bg-danger';
                    $statusText = 'Dibatalkan';
                } elseif ($row->status == 'completed') {
                    $statusClass = 'badge bg-info';
                    $statusText = 'Selesai';
                } else {
                    $statusClass = 'badge bg-secondary';
                }

                return '<span class="' . $statusClass . '">' . $statusText . '</span>';
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('action', function ($row) {
                $viewBtn = '<a href="' . route('admin.orders.show', $row->id) . '" class="btn btn-sm btn-info"><i class="ri-eye-fill"></i></a>';
                $editBtn = '<a href="' . route('admin.orders.edit', $row->id) . '" class="btn btn-sm btn-success"><i class="ri-pencil-fill"></i></a>';
                $deleteBtn = '<form action="' . route('admin.orders.destroy', $row->id) . '" method="POST" class="delete-form d-inline">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="ri-delete-bin-fill"></i>
                    </button>
                </form>';

                return '<div class="d-flex gap-2">' . $viewBtn . $editBtn . $deleteBtn . '</div>';
            })
            ->rawColumns(['action', 'status'])
            ->toJson();
    }

    public function create()
    {
        $vehicles = Vehicle::where('status', 'ready')->get();
        $drivers = Driver::where('status', 'active')->get();

        return view('admin.orders.create', compact('vehicles', 'drivers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'pickup_address' => 'required|string|max:500',
            'destination' => 'required|string|max:255',
            'route' => 'required|string|max:1000',
            'vehicle_count' => 'required|integer|min:1|max:10',
            'vehicle_type' => 'required|string|exists:vehicles,type',
            'driver_name' => 'required|string',
            'rental_price' => 'required|numeric|min:0',
            'down_payment' => 'nullable|numeric|min:0|lte:rental_price',
            'remaining_cost' => 'nullable|numeric|min:0',
            'status' => 'required|in:waiting,approved,canceled',
            'additional_notes' => 'nullable|string|max:1000',
        ], [
            'vehicle_type.exists' => 'Tipe armada yang dipilih tidak valid.',
            'down_payment.lte' => 'Uang muka tidak boleh lebih besar dari harga sewa.',
            'vehicle_count.max' => 'Jumlah armada maksimal 10 unit.',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
            'status.in' => 'Status yang dipilih tidak valid.',
        ]);

        // Calculate remaining cost
        if (isset($validated['rental_price'])) {
            $rentalPrice = $validated['rental_price'];
            $downPayment = $validated['down_payment'] ?? 0;
            $validated['remaining_cost'] = $rentalPrice - $downPayment;
        }

        $validated['user_id'] = auth()->id();

        // Check if driver exists and get driver_id
        $driver = Driver::whereHas('user', function ($query) use ($validated) {
            $query->where('name', $validated['driver_name']);
        })->first();

        if (!$driver) {
            return redirect()->back()->withInput()->withErrors(['driver_name' => 'Driver yang dipilih tidak valid.']);
        }

        $validated['driver_id'] = $driver->id;

        Order::create($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil dibuat!');
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $vehicles = Vehicle::where('status', 'ready')->get();
        $drivers = Driver::where('status', 'active')->get();

        return view('admin.orders.edit', compact('order', 'vehicles', 'drivers'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'pickup_address' => 'required|string|max:500',
            'destination' => 'required|string|max:255',
            'route' => 'required|string|max:1000',
            'vehicle_count' => 'required|integer|min:1|max:10',
            'vehicle_type' => 'required|string|exists:vehicles,type',
            'driver_name' => 'required|string',
            'rental_price' => 'required|numeric|min:0',
            'down_payment' => 'nullable|numeric|min:0|lte:rental_price',
            'remaining_cost' => 'nullable|numeric|min:0',
            'status' => 'required|in:waiting,approved,canceled,completed',
            'additional_notes' => 'nullable|string|max:1000',
        ], [
            'vehicle_type.exists' => 'Tipe armada yang dipilih tidak valid.',
            'down_payment.lte' => 'Uang muka tidak boleh lebih besar dari harga sewa.',
            'vehicle_count.max' => 'Jumlah armada maksimal 10 unit.',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
            'status.in' => 'Status yang dipilih tidak valid.',
        ]);

        // Calculate remaining cost
        if (isset($validated['rental_price'])) {
            $rentalPrice = $validated['rental_price'];
            $downPayment = $validated['down_payment'] ?? 0;
            $validated['remaining_cost'] = $rentalPrice - $downPayment;
        }

        // Check if driver exists and get driver_id
        $driver = Driver::whereHas('user', function ($query) use ($validated) {
            $query->where('name', $validated['driver_name']);
        })->first();

        if (!$driver) {
            return redirect()->back()->withInput()->withErrors(['driver_name' => 'Driver yang dipilih tidak valid.']);
        }

        $validated['driver_id'] = $driver->id;

        $order->update($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil diubah!');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil dihapus!');
    }

    public function assignDriver(Request $request, Order $order)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
        ], [
            'driver_id.required' => 'Driver harus dipilih.',
            'driver_id.exists' => 'Driver yang dipilih tidak valid.',
        ]);

        $driver = Driver::findOrFail($validated['driver_id']);

        $order->update([
            'driver_id' => $driver->id,
            'driver_name' => $driver->user->name,
        ]);

        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Driver berhasil ditugaskan!');
    }

    public function changeStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:waiting,approved,canceled,completed',
        ], [
            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status yang dipilih tidak valid.',
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Status order berhasil diubah!');
    }
}
