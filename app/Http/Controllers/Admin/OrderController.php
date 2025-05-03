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
                    'Hiace' => '#4285F4',           // bright blue
                    'Elf' => '#EA4335',             // bright red
                    'Bus' => '#9C27B0',             // purple
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

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->where(function ($q) use ($request) {
                $q->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                    ->orWhere(function ($q2) use ($request) {
                        $q2->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                    });
            });
        }
        // Backward compatibility for single date filter
        elseif ($request->has('date') && $request->date) {
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
                } else {
                    $statusClass = 'badge bg-secondary';
                }

                return '<span class="' . $statusClass . '">' . $statusText . '</span>';
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('action', function ($row) {
                $editBtn = '<a href="' . route('admin.orders.edit', $row->id) . '" class="btn btn-sm btn-success"><i class="ri-pencil-fill"></i></a>';
                $deleteBtn = '<form action="' . route('admin.orders.destroy', $row->id) . '" method="POST" class="delete-form d-inline">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="ri-delete-bin-fill"></i>
                    </button>
                </form>';

                return '<div class="d-flex gap-2">' . $editBtn . $deleteBtn . '</div>';
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
            'rental_price' => 'required|numeric|min:0',
            'down_payment' => 'nullable|numeric|min:0|lte:rental_price',
            'remaining_cost' => 'nullable|numeric|min:0',
            'status' => 'required|in:waiting,approved,canceled',
            'additional_notes' => 'nullable|string|max:1000',
            'vehicle_ids' => 'required|array',
            'vehicle_ids.*' => 'exists:vehicles,id',
            'driver_ids' => 'required|array',
            'driver_ids.*' => 'exists:drivers,id',
        ], [
            'down_payment.lte' => 'Uang muka tidak boleh lebih besar dari harga sewa.',
            'vehicle_count.max' => 'Jumlah armada maksimal 10 unit.',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
            'status.in' => 'Status yang dipilih tidak valid.',
            'vehicle_ids.required' => 'Pilih minimal satu armada.',
            'driver_ids.required' => 'Pilih minimal satu driver.',
        ]);

        if (isset($validated['rental_price'])) {
            $rentalPrice = $validated['rental_price'];
            $downPayment = $validated['down_payment'] ?? 0;
            $validated['remaining_cost'] = $rentalPrice - $downPayment;
        }

        $validated['user_id'] = auth()->id();

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

        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil dibuat!');
    }

    /**
     * Get order details for modal
     */
    public function detail(Order $order)
    {
        // Load relationships
        $order->load(['vehicles', 'drivers']);

        return response()->json($order);
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
            'rental_price' => 'required|numeric|min:0',
            'down_payment' => 'nullable|numeric|min:0|lte:rental_price',
            'remaining_cost' => 'nullable|numeric|min:0',
            'status' => 'required|in:waiting,approved,canceled',
            'additional_notes' => 'nullable|string|max:1000',
            'vehicle_ids' => 'required|array',
            'vehicle_ids.*' => 'exists:vehicles,id',
            'driver_ids' => 'required|array',
            'driver_ids.*' => 'exists:drivers,id',
        ], [
            'down_payment.lte' => 'Uang muka tidak boleh lebih besar dari harga sewa.',
            'vehicle_count.max' => 'Jumlah armada maksimal 10 unit.',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
            'status.in' => 'Status yang dipilih tidak valid.',
            'vehicle_ids.required' => 'Pilih minimal satu armada.',
            'driver_ids.required' => 'Pilih minimal satu driver.',
        ]);

        if (isset($validated['rental_price'])) {
            $rentalPrice = $validated['rental_price'];
            $downPayment = $validated['down_payment'] ?? 0;
            $validated['remaining_cost'] = $rentalPrice - $downPayment;
        }

        // Get the first driver for backward compatibility
        $primaryDriver = Driver::find($validated['driver_ids'][0]);
        $validated['driver_id'] = $primaryDriver->id;
        $validated['driver_name'] = $primaryDriver->user->name;

        // Get the first vehicle's type for the vehicle_type field
        $primaryVehicle = Vehicle::find($validated['vehicle_ids'][0]);
        $validated['vehicle_type'] = $primaryVehicle->type;

        $order->update($validated);
        $order->vehicles()->sync($validated['vehicle_ids']);
        $order->drivers()->sync($validated['driver_ids']);

        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil diubah!');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil dihapus!');
    }
}
