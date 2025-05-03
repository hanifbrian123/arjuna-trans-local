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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $orders = Order::with(['user', 'driver', 'vehicle'])
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->successResponse(
            OrderResource::collection($orders),
            'Daftar pesanan berhasil dimuat'
        );
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
            $order = Order::create($request->validated());

            return $this->successResponse(
                new OrderResource($order),
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
        $order->load(['user', 'driver', 'vehicle']);

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
            $order->update($request->validated());

            return $this->successResponse(
                new OrderResource($order->fresh()),
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
