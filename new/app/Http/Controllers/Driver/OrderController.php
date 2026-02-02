<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
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
        return view('driver.orders.index', compact('vehicles'));
    }

    public function calendar(Request $request)
    {
        // Get all vehicles for filter options
        $vehicles = Vehicle::where('status', 'ready')->get();

        if ($request->ajax()) {
            // Get only orders assigned to the current driver with 'approved' status
            $query = Order::where('driver_id', auth()->user()->driver->id)
                ->where('status', 'approved');

            // Filter by vehicle type if provided
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
                'NKR 55 LWB' => '#4285F4',           // bright blue
                'HINO MDBL' => '#FBBC05',             // bright red
                'HINO FB' => '#34A853',             // purple
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
                    'className' => 'event-' . $order->status,
                    'extendedProps' => [
                        'customer' => $order->name,
                        'phone' => $order->phone_number,
                        'destination' => $order->destination,
                        'vehicle_type' => $order->vehicle_type,
                        'pickup' => $order->pickup_address,
                        'status' => $order->status
                    ]
                ];
            }

            return response()->json($events);
        }

        return view('driver.orders.calendar', compact('vehicles'));
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
        // Get only orders that are either:
        // 1. Assigned to the current driver (driver_id matches)
        // 2. Waiting to be accepted (status = waiting) and not yet assigned to any driver
        $query = Order::where(function ($q) {
            $q->where('driver_id', auth()->user()->driver->id)
                ->orWhere(function ($q2) {
                    $q2->where('status', 'waiting')
                        ->whereNull('driver_id');
                });
        });

        // Apply filters from request
        $request = request();

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q2) use ($startDate, $endDate) {
                        $q2->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            });
        }
        // Backward compatibility for old date filter
        else if ($request->has('date') && $request->date) {
            $date = $request->date;
            $query->whereDate('start_date', '<=', $date)
                ->whereDate('end_date', '>=', $date);
        }

        // Filter by vehicle type
        if ($request->has('vehicle_type') && $request->vehicle_type) {
            $query->where('vehicle_type', $request->vehicle_type);
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
            ->addColumn('nama_pemesan', function ($row) {
                $nama = $row->name ?? '-';
                $noTelepon = $row->phone_number ?? '-';
            
                if ($noTelepon !== '-') {
                    // Bersihkan karakter non-digit
                    $noTeleponBersih = preg_replace('/[^0-9]/', '', $noTelepon);
            
                    // Ganti awalan 0 dengan +62
                    if (substr($noTeleponBersih, 0, 1) === '0') {
                        $noTeleponWA = '+62' . substr($noTeleponBersih, 1);
                    } else {
                        $noTeleponWA = '+62' . $noTeleponBersih; // fallback
                    }
            
                    $linkTelepon = '<a href="https://wa.me/' . str_replace('+', '', $noTeleponWA) . '" target="_blank">' . $noTeleponWA . '</a>';
                } else {
                    $linkTelepon = '-';
                }
            
                return $nama . '<br>' . $linkTelepon;
            })                        
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('action', function ($row) {
                // Hanya tampilkan tombol edit jika status bukan approved
                $cetakBtn = '<a href="' . route('driver.orders.cetak', $row->id) . '" class="btn btn-sm btn-warning" target="_blank"><i class="ri-file-fill" title="Cetak Order"></i></a>';
                $editBtn = '<a href="' . route('driver.orders.edit', $row->id) . '" class="btn btn-sm btn-primary"><i class="ri-edit-fill" title="Edit Order"></i></a>';
                if ($row->status != 'approved') {
                    return '<div class="d-flex gap-2">' . $editBtn . '</div>';
                }else{
                    return '<div class="d-flex gap-2">' . $editBtn . $cetakBtn . '</div>';
                }

                return '<div class="text-muted"><small>Tidak ada aksi</small></div>';
            })
            ->rawColumns(['action', 'status','nama_pemesan'])
            ->toJson();
    }

    public function show(Order $order)
    {
        // Check if the driver is authorized to view this order
        if ($order->driver_id && $order->driver_id != auth()->user()->driver->id && $order->status != 'waiting') {
            return redirect()->route('driver.orders.index')->with('error', 'Anda tidak memiliki akses untuk melihat order ini.');
        }

        return view('driver.orders.show', compact('order'));
    }

    /**
     * Get order details for modal
     */
    public function detail(Order $order)
    {
        // Check if the driver is authorized to view this order
        if ($order->driver_id && $order->driver_id != auth()->user()->driver->id && $order->status != 'waiting') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Load relationships
        $order->load('vehicles');

        return response()->json($order);
    }

    public function accept(Order $order)
    {
        // Check if the order is still waiting and not assigned to any driver
        if ($order->status != 'waiting' || $order->driver_id) {
            return redirect()->route('driver.orders.index')->with('error', 'Order ini tidak dapat diterima.');
        }

        $order->update([
            'status' => 'approved',
            'driver_id' => auth()->user()->driver->id,
            'driver_name' => auth()->user()->name
        ]);

        return redirect()->route('driver.orders.index')->with('success', 'Order berhasil diterima!');
    }

    public function edit(Order $order)
    {
        // Check if the order belongs to this driver or is a waiting order
        // AND check if the order is not approved
        if (
            (!($order->user_id == auth()->id() || ($order->status == 'waiting' && !$order->driver_id))) ||
            $order->status == 'approved'
        ) {
            return redirect()->route('driver.orders.index')->with('error', 'Anda tidak memiliki akses untuk mengedit order ini.');
        }

        // Get available vehicles
        $vehicles = Vehicle::where('status', 'ready')->get();

        // Get current driver
        $driver = auth()->user()->driver;

        return view('driver.orders.edit', compact('order', 'vehicles', 'driver'));
    }

    public function update(Request $request, Order $order)
    {
        // Check if the order belongs to this driver or is a waiting order
        // AND check if the order is not approved
        if (
            (!($order->user_id == auth()->id() || ($order->status == 'waiting' && !$order->driver_id))) ||
            $order->status == 'approved'
        ) {
            return redirect()->route('driver.orders.index')->with('error', 'Anda tidak memiliki akses untuk mengedit order ini.');
        }

        // Prepare the request data
        $data = $request->all();

        // Convert date strings to proper format if needed
        if (isset($data['start_date'])) {
            try {
                $data['start_date'] = \Carbon\Carbon::parse($data['start_date'])->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                // Keep original value if parsing fails
            }
        }

        if (isset($data['end_date'])) {
            try {
                $data['end_date'] = \Carbon\Carbon::parse($data['end_date'])->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                // Keep original value if parsing fails
            }
        }

        // Validate the data
        $validated = validator($data, [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'pickup_address' => 'required|string|max:500',
            'destination' => 'required|string|max:255',
            'route' => 'required|string|max:1000',
            'vehicle_count' => 'required|integer|min:1|max:10',
            'rental_price' => 'present|numeric|min:0', // Changed from required to present
            'down_payment' => 'required|numeric|min:0', // Changed from nullable to required
            'remaining_cost' => 'present|numeric|min:0', // Changed from nullable to present
            'additional_notes' => 'nullable|string|max:1000',
            'vehicle_ids' => 'required|array',
            'vehicle_ids.*' => 'exists:vehicles,id',
        ])->validate();

        // Don't change the status
        $validated['status'] = $order->status;

        // Don't change the driver
        $validated['driver_id'] = $order->driver_id;
        $validated['driver_name'] = $order->driver_name;

        // Get the first vehicle's type for the vehicle_type field
        $primaryVehicle = Vehicle::find($validated['vehicle_ids'][0]);
        $validated['vehicle_type'] = $primaryVehicle->type;

        // Update the order
        $order->update($validated);

        // Sync vehicles
        $order->vehicles()->sync($validated['vehicle_ids']);

        // Sync drivers if provided
        if (isset($data['driver_ids'])) {
            $order->drivers()->sync($data['driver_ids']);
        }

        return redirect()->route('driver.orders.index')->with('success', 'Order berhasil diperbarui!');
    }

    public function create()
    {
        // Get available vehicles
        $vehicles = Vehicle::where('status', 'ready')->get();

        // Get current driver
        $driver = auth()->user()->driver;

        return view('driver.orders.create', compact('vehicles', 'driver'));
    }

    public function store(Request $request)
    {
        // Prepare the request data
        $data = $request->all();

        // Convert date strings to proper format if needed
        if (isset($data['start_date'])) {
            try {
                $data['start_date'] = \Carbon\Carbon::parse($data['start_date'])->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                // Keep original value if parsing fails
            }
        }

        if (isset($data['end_date'])) {
            try {
                $data['end_date'] = \Carbon\Carbon::parse($data['end_date'])->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                // Keep original value if parsing fails
            }
        }

        // Validate the data
        $validated = validator($data, [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'pickup_address' => 'required|string|max:500',
            'destination' => 'required|string|max:255',
            'route' => 'required|string|max:1000',
            'vehicle_count' => 'required|integer|min:1|max:10',
            'rental_price' => 'present|numeric|min:0', // Changed from required to present
            'down_payment' => 'required|numeric|min:0', // Changed from nullable to required
            'remaining_cost' => 'present|numeric|min:0', // Changed from nullable to present
            'additional_notes' => 'nullable|string|max:1000',
            'vehicle_ids' => 'required|array',
            'vehicle_ids.*' => 'exists:vehicles,id',
        ])->validate();

        // Set status to waiting by default
        $validated['status'] = 'waiting';

        // Set the current user as the creator
        $validated['user_id'] = auth()->id();

        // Set driver name but leave driver_id empty (admin will assign later)
        $validated['driver_name'] = auth()->user()->name;

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

        // Create the order
        $order = Order::create($validated);

        // Attach vehicles
        $order->vehicles()->attach($validated['vehicle_ids']);

        // Attach drivers
        if (isset($validated['driver_ids'])) {
            $order->drivers()->attach($validated['driver_ids']);
        }

        // Driver will be attached by admin later

        return redirect()->route('driver.orders.index')->with('success', 'Order berhasil dibuat!');
    }

    public function cetakInvoice(Request $request, Order $order) 
    {
        $id = $request->id ?? $order->id;
        
        $data['data'] = Order::with('vehicles')
        ->where('id', $id)->first();
        
        if(!empty($request->id)){
            $html = view('driver.orders.cetak', $data)->render();
            return response()->json(['status' => 'success', 'code' => 200, 'html' => $html]);
        }else{
            $data = $data['data'];
            return view('driver.orders.cetak', compact('data'));            
        }
      }
}

