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
                    'url' => route('driver.orders.show', $order->id),
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
                $viewBtn = '<a href="' . route('driver.orders.show', $row->id) . '" class="btn btn-sm btn-info"><i class="ri-eye-fill"></i></a>';

                $buttons = '<div class="d-flex gap-2">' . $viewBtn;

                // Add accept button for waiting orders
                if ($row->status == 'waiting' && !$row->driver_id) {
                    $acceptBtn = '<form action="' . route('driver.orders.accept', $row->id) . '" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        ' . method_field('PUT') . '
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="ri-check-line"></i> Terima
                        </button>
                    </form>';
                    $buttons .= $acceptBtn;
                }

                // Add complete button for approved orders assigned to this driver
                if ($row->status == 'approved' && $row->driver_id == auth()->user()->driver->id) {
                    $completeBtn = '<form action="' . route('driver.orders.complete', $row->id) . '" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        ' . method_field('PUT') . '
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="ri-check-double-line"></i> Selesai
                        </button>
                    </form>';
                    $buttons .= $completeBtn;
                }

                $buttons .= '</div>';

                return $buttons;
            })
            ->rawColumns(['action', 'status'])
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

    public function complete(Order $order)
    {
        // Check if the order is assigned to this driver and is approved
        if ($order->status != 'approved' || $order->driver_id != auth()->user()->driver->id) {
            return redirect()->route('driver.orders.index')->with('error', 'Order ini tidak dapat diselesaikan.');
        }

        $order->update([
            'status' => 'approved'
        ]);

        return redirect()->route('driver.orders.index')->with('success', 'Order berhasil diselesaikan!');
    }
}
