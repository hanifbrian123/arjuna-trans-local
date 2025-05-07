<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Order;
use App\Models\Driver;
use App\Traits\ApiResponser;
use App\Http\Resources\OrderResource;
use App\Http\Requests\API\OrderRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

/**
 * @group Pengelolaan Pesanan
 *
 * API untuk mengelola data pesanan
 */
class OrderController extends Controller
{
    use ApiResponser;

    /**
     * Menampilkan daftar pesanan
     *
     * Endpoint ini digunakan untuk mendapatkan daftar semua pesanan.
     * Dapat difilter berdasarkan tanggal, status, dan driver.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $query = Order::with(['user', 'drivers', 'vehicles']);

            if ($request->has('start_date') && $request->has('end_date')) {
                //start date with range
                $query->whereDate('start_date', '>=', $request->start_date)
                    ->whereDate('start_date', '<=', $request->end_date);
            }

            // Filter by status if provided
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            // Filter by driver if provided
            // if ($request->has('driver_id') && $request->driver_id) {
            //     $query->where('driver_id', $request->driver_id);
            // }

            // Filter by vehicle/armada if provided
            // if ($request->has('vehicle_type') && $request->vehicle_type) {
            //     $query->where('vehicle_type', $request->vehicle_type);
            // }

            // Order by start date (newest first) by default
            $query->orderBy('start_date', 'desc');

            $orders = $query->get();

            return $this->successResponse(
                OrderResource::collection($orders),
                'Daftar pesanan berhasil dimuat'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal memuat daftar pesanan: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Menampilkan daftar pesanan untuk kalender
     *
     * Endpoint ini digunakan untuk mendapatkan daftar pesanan untuk tampilan kalender.
     * Hanya menampilkan pesanan dengan status 'approved'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calendar(Request $request)
    {
        try {
            $query = Order::with(['user', 'drivers', 'vehicles'])
                ->where('status', 'approved');

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

            // // Filter by driver if provided
            // if ($request->has('driver_id') && $request->driver_id) {
            //     $query->where('driver_id', $request->driver_id);
            // }

            // // Filter by vehicle/armada if provided
            // if ($request->has('vehicle_type') && $request->vehicle_type) {
            //     $query->where('vehicle_type', $request->vehicle_type);
            // }

            $orders = $query->get();

            // Format data for calendar
            $events = $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'title' => $order->name . ' - ' . $order->vehicle_type,
                    'start' => $order->start_date->format('Y-m-d\TH:i:s'),
                    'end' => $order->end_date->format('Y-m-d\TH:i:s'),
                    'extendedProps' => [
                        'order_num' => $order->order_num,
                        'customer' => $order->name,
                        'phone' => $order->phone_number,
                        'destination' => $order->destination,
                        'route' => $order->route,
                        'pickup_address' => $order->pickup_address,
                        'driver_name' => $order->drivers->first() ? $order->drivers->first()->user->name : null,
                        'vehicle_type' => $order->vehicle_type,
                        'status' => $order->status,
                    ],
                    'backgroundColor' => $this->getEventColor($order->vehicle_type),
                    'borderColor' => $this->getEventColor($order->vehicle_type),
                ];
            });

            return $this->successResponse(
                $events,
                'Data kalender berhasil dimuat'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal memuat data kalender: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get color for calendar event based on vehicle type
     *
     * @param string $vehicleType
     * @return string
     */
    private function getEventColor($vehicleType)
    {
        $colors = [
            'ISUZU ELF LONG' => '#4CAF50',
            'ISUZU ELF SHORT' => '#2196F3',
            'TOYOTA HIACE' => '#FF9800',
            'TOYOTA ALPHARD' => '#9C27B0',
            'MERCEDES BENZ SPRINTER' => '#F44336',
            'TOYOTA AVANZA' => '#00BCD4',
            'TOYOTA INNOVA' => '#795548',
            'TOYOTA FORTUNER' => '#607D8B',
        ];

        return $colors[$vehicleType] ?? '#3788d8'; // Default color
    }

    /**
     * Menyimpan pesanan baru
     *
     * Endpoint ini digunakan untuk membuat data pesanan baru.
     *
     * @param  \App\Http\Requests\API\OrderRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OrderRequest $request)
    {
        try {
            $validated = $request->validated();

            // Calculate remaining cost if down payment is provided
            if (isset($validated['down_payment']) && $validated['down_payment'] > 0) {
                $validated['remaining_cost'] = $validated['rental_price'] - $validated['down_payment'];
            } else {
                $validated['down_payment'] = 0;
                $validated['remaining_cost'] = $validated['rental_price'];
            }

            // Set user_id from authenticated user if not provided
            if (!isset($validated['user_id'])) {
                $validated['user_id'] = auth()->id();
            }

            // Generate order number (format: AT-YYYYMMDD-XXX)
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
            $validated['order_num'] = 'AT-' . $date . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

            // Create the order
            $order = Order::create($validated);

            // Attach vehicles
            if (isset($validated['vehicle_ids']) && is_array($validated['vehicle_ids'])) {
                $order->vehicles()->attach($validated['vehicle_ids']);
            }

            return $this->successResponse(
                new OrderResource($order->load(['user', 'drivers', 'vehicles'])),
                'Pesanan berhasil dibuat',
                201
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal membuat pesanan: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Menampilkan detail pesanan
     *
     * Endpoint ini digunakan untuk mendapatkan detail data pesanan berdasarkan ID.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Order $order)
    {
        $order->load(['user', 'drivers', 'vehicles']);

        return $this->successResponse(
            new OrderResource($order),
            'Detail pesanan berhasil dimuat'
        );
    }

    /**
     * Memperbarui data pesanan
     *
     * Endpoint ini digunakan untuk memperbarui data pesanan yang sudah ada.
     *
     * @param  \App\Http\Requests\API\OrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(OrderRequest $request, Order $order)
    {
        try {
            $validated = $request->validated();

            // Calculate remaining cost if down payment is provided
            if (isset($validated['down_payment']) && isset($validated['rental_price'])) {
                $validated['remaining_cost'] = $validated['rental_price'] - $validated['down_payment'];
            } elseif (isset($validated['down_payment'])) {
                $validated['remaining_cost'] = $order->rental_price - $validated['down_payment'];
            } elseif (isset($validated['rental_price'])) {
                $validated['remaining_cost'] = $validated['rental_price'] - ($order->down_payment ?? 0);
            }

            // Update the order
            $order->update($validated);

            // Update vehicles if provided
            if (isset($validated['vehicle_ids']) && is_array($validated['vehicle_ids'])) {
                $order->vehicles()->sync($validated['vehicle_ids']);
            }

            return $this->successResponse(
                new OrderResource($order->fresh()->load(['user', 'drivers', 'vehicles'])),
                'Pesanan berhasil diperbarui'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal memperbarui pesanan: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Menghapus pesanan
     *
     * Endpoint ini digunakan untuk menghapus data pesanan.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Order $order)
    {
        try {
            $order->delete();

            return $this->successResponse(
                null,
                'Pesanan berhasil dihapus'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal menghapus pesanan: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Menugaskan driver ke pesanan
     *
     * Endpoint ini digunakan untuk menugaskan driver ke pesanan tertentu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignDriver(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'driver_id' => 'required|exists:drivers,id',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        try {
            $driver = Driver::findOrFail($request->driver_id);

            $order->driver_id = $driver->id;
            $order->status = 'approved';
            $order->save();

            return $this->successResponse(
                new OrderResource($order->load(['driver', 'user', 'vehicle'])),
                'Driver berhasil ditugaskan'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal menugaskan driver: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Mengubah status pesanan
     *
     * Endpoint ini digunakan untuk mengubah status pesanan.
     * Status yang tersedia: waiting, approved, canceled
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:waiting,approved,canceled',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        try {
            $order->status = $request->status;
            $order->save();

            return $this->successResponse(
                new OrderResource($order),
                'Status pesanan berhasil diperbarui'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal memperbarui status pesanan: ' . $e->getMessage(), 500);
        }
    }
}
