<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
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

        $query->Where('end_date', '>', Carbon::now())
                ->orderByRaw("STR_TO_DATE(start_date, '%Y-%m-%d %H:%i:%s') ASC")            
                ->get();


        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                $statusClass = '';
                $statusText = $row->status;

                if ($row->status == 'waiting' && $row->trip_completed == '0') {
                    $statusClass = 'badge bg-warning';
                    $statusText = 'Menunggu';
                } elseif ($row->status == 'approved' && $row->trip_completed == '0') {
                    $statusClass = 'badge bg-success';
                    $statusText = 'Disetujui';
                } elseif ($row->status == 'approved' && $row->trip_completed == '1') {
                    $statusClass = 'badge bg-info';
                    $statusText = 'Terselesaikan';                
                } elseif ($row->status == 'canceled' && $row->trip_completed == '0') {
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
            ->addColumn('action', function ($row) {
                $editBtn = '<a href="' . route('admin.orders.edit', $row->id) . '" class="btn btn-sm btn-primary" title="klik untuk edit"><i class="ri-edit-fill"></i></a>';
                $cetakBtn = '<a href="' . route('admin.orders.cetak', $row->id) . '" class="btn btn-sm btn-warning" target="_blank" title="klik untuk cetak"><i class="ri-file-fill"></i></a>';
                $finishBtn = '<form action="' . route('admin.orders.finished', $row->id) . '" method="POST" class="finished-form d-inline" title="klik untuk menyelesaikan">
                    ' . csrf_field() . '
                    ' . method_field('POST') . '
                    <button type="submit" class="btn btn-sm btn-info">
                        <i class="ri-check-fill"></i>
                    </button>
                </form>';

                $deleteBtn = '<form action="' . route('admin.orders.destroy', $row->id) . '" method="POST" class="delete-form d-inline" title="klik untuk hapus">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="ri-delete-bin-fill"></i>
                    </button>
                </form>';

                if ($row->status == 'waiting') {
                    return '<div class="d-flex gap-2">' . $editBtn . $deleteBtn . '</div>';
                } else if ($row->status == 'approved' && $row->trip_completed == 1) {
                    return '<div class="d-flex gap-2">' . $editBtn . $cetakBtn .'</div>';
                } else {
                    return '<div class="d-flex gap-2">' . $editBtn . $cetakBtn . $finishBtn . '</div>';
                }
            })
            
            ->rawColumns(['action', 'status','nama_pemesan'])
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
            'rental_price' => 'required|min:0',
            'down_payment' => 'nullable|min:0|lte:rental_price',
            'remaining_cost' => 'nullable|min:0',
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

        $validated['rental_price'] = (int) str_replace(['Rp', '.', ' '], '', $request->rental_price);
        $validated['down_payment'] = (int) str_replace(['Rp', '.', ' '], '', $request->down_payment ?? '0');

        if (isset($validated['rental_price'])) {
            $validated['remaining_cost'] = $validated['rental_price'] - $validated['down_payment'];
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
            'rental_price' => 'required',
            'down_payment' => 'nullable|lte:rental_price',
            'remaining_cost' => 'nullable',
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

        $validated['rental_price'] = (int) str_replace(['Rp', '.', ' '], '', $request->rental_price);
        $validated['down_payment'] = (int) str_replace(['Rp', '.', ' '], '', $request->down_payment ?? '0');

        if (isset($validated['rental_price'])) {
            $validated['remaining_cost'] = $validated['rental_price'] - $validated['down_payment'];
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

    public function cetakInvoice(Request $request, Order $order)
    {
        $id = $request->id ?? $order->id;

        $data['data'] = Order::with('vehicles')
            ->where('id', $id)->first();

        if (!empty($request->id)) {
            $html = view('admin.orders.cetak', $data)->render();
            return response()->json(['status' => 'success', 'code' => 200, 'html' => $html]);
        } else {
            $data = $data['data'];
            return view('admin.orders.cetak', compact('data'));
        }
    }

    public function tripFinished(Request $request)
    {
        $orders = Order::Where('end_date', '<', Carbon::now())
        // where('trip_completed', 1)
        ->get();        

        return DataTables::of($orders)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                $statusClass = '';
                $statusText = $row->status;

                if ($row->status == 'waiting' && $row->trip_completed == '0') {
                    $statusClass = 'badge bg-warning';
                    $statusText = 'Menunggu';
                } elseif ($row->status == 'approved' && $row->trip_completed == '0') {
                    $statusClass = 'badge bg-success';
                    $statusText = 'Disetujui';
                } elseif ($row->status == 'approved' && $row->trip_completed == '1') {
                    $statusClass = 'badge bg-info';
                    $statusText = 'Terselesaikan';                
                } elseif ($row->status == 'canceled' && $row->trip_completed == '0') {
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
            ->addColumn('action', function ($row) {
                $cetakBtn = '<a href="' . route('admin.orders.cetak', $row->id) . '" class="btn btn-sm btn-warning" target="_blank" title="klik untuk cetak"><i class="ri-file-fill"></i></a>';                                

                $editBtn = '<a href="' . route('admin.orders.edit', $row->id) . '" class="btn btn-sm btn-primary" title="klik untuk edit"><i class="ri-edit-fill"></i></a>';

                $finishBtn = '<form action="' . route('admin.orders.finished', $row->id) . '" method="POST" class="finished-form d-inline" title="klik untuk menyelesaikan">
                    ' . csrf_field() . '
                    ' . method_field('POST') . '
                    <button type="submit" class="btn btn-sm btn-info">
                        <i class="ri-check-fill"></i>
                    </button>
                </form>';

                if($row->status == 'approved' && $row->trip_completed == 1) {
                    return '<div class="d-flex gap-2">' .  $cetakBtn .'</div>';                
                }else{
                    return '<div class="d-flex gap-2">' .  $cetakBtn . $finishBtn . $editBtn . '</div>';                
                }

            })
            
            ->rawColumns(['action', 'status','nama_pemesan'])
            ->toJson();
    }

    /**
     * Omset per armada (distribute order cash-in equally among attached vehicles)
     */
        public function omset(Request $request)
        {
            $vehicleId = $request->vehicle_id ?? null;

            // Vehicles list for dropdown
            $vehicles = Vehicle::get();

            $query = Order::with('vehicles')->orderBy('created_at', 'desc');

            // Filter by selected vehicle (orders that include the vehicle)
            if ($vehicleId) {
                $query->whereHas('vehicles', function ($q) use ($vehicleId) {
                    $q->where('vehicles.id', $vehicleId);
                });
            }

            // Apply created_at date filter (created date range)
            if ($request->has('start_date') && $request->has('end_date') && $request->start_date && $request->end_date) {
                $start = $request->start_date . ' 00:00:00';
                $end = $request->end_date . ' 23:59:59';
                $query->whereBetween('created_at', [$start, $end]);
            }

            $orders = $query->get();

            $rows = collect();
            $totalCashIn = 0;
            $totalOrder = 0;

            foreach ($orders as $order) {
                $cashIn = $order->rental_price ?? 0;
                // $cashIn = (float) ($order->rental_price ?? 0) - (float) ($order->remaining_cost ?? 0);
                $vehicleCount = $order->vehicles->count() ?: ($order->vehicle_count ?: 1);
                $perVehicle = $vehicleCount ? ($cashIn / $vehicleCount) : 0;

                if ($cashIn <= 0) {
                    continue;
                }

                if ($order->vehicles->count() > 0) {
                    foreach ($order->vehicles as $vehicle) {
                        // When filtering by vehicle, only push rows for that vehicle
                        if ($vehicleId && $vehicle->id != $vehicleId) {
                            continue;
                        }

                        $rows->push((object) [
                            'vehicle' => $vehicle,
                            'created_at' => $order->created_at,
                            'order_num' => $order->order_num,
                            'cash_in' => $perVehicle,
                            'destination' => $order->destination,
                            'name' => $order->name
                        ]);
                        $totalCashIn += $perVehicle;
                    }
                } else {
                    // Fallback: if filtering by vehicle skip rows without vehicle
                    if ($vehicleId) {
                        continue;
                    }

                    $rows->push((object) [
                        'vehicle' => null,
                        'created_at' => $order->created_at,
                        'order_num' => $order->order_num,
                        'cash_in' => $perVehicle,
                        'destination' => $order->destination,
                        'name' => $order->name
                    ]);
                    $totalCashIn += $perVehicle;
                }
                $totalOrder++;
            }

            $startDate = $request->start_date ?? null;
            $endDate = $request->end_date ?? null;

            $avgCashIn = $totalOrder ? ($totalCashIn / $totalOrder) : 0;
            return view('admin.orders.omset', compact('rows', 'totalCashIn', 'startDate', 'endDate', 'avgCashIn', 'totalOrder', 'vehicles', 'vehicleId'));
        }

    public function finished(Order $order)
    {
        $order->trip_completed = 1;
        $order->save();
        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil diselesaikan!');
    }
}
