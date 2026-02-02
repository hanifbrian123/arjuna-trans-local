<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Order;
use App\Traits\ApiResponser;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

/**
 * @group Pengelolaan Pembayaran
 *
 * API untuk mengelola data pembayaran
 */
class PaymentController extends Controller
{
    use ApiResponser;

    /**
     * Menampilkan daftar pembayaran
     *
     * Endpoint ini digunakan untuk mendapatkan daftar pembayaran dari pesanan yang telah selesai.
     * Dapat difilter berdasarkan rentang tanggal, status pembayaran, dan driver.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $query = Order::with(['user', 'drivers', 'vehicles'])
                ->whereIn('status', ['approved', 'waiting']);

            // Filter by date range if provided
            if ($request->has('start_date') && $request->has('end_date')) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
            }

            // Filter by payment status if provided
            if ($request->has('payment_status')) {
                if ($request->payment_status === 'paid') {
                    // Fully paid orders (remaining_cost is 0 or null)
                    $query->where(function ($q) {
                        $q->whereRaw('remaining_cost = 0')
                            ->orWhereNull('remaining_cost');
                    });
                } else if ($request->payment_status === 'unpaid') {
                    // Orders with remaining balance
                    $query->whereRaw('remaining_cost > 0');
                }
            }

            // Filter by driver if provided
            if ($request->has('driver_id')) {
                $query->whereHas('drivers', function ($q) use ($request) {
                    $q->where('driver_id', $request->driver_id);
                });
            }

            $payments = $query->orderBy('created_at', 'desc')->get();

            // Calculate totals
            $totalRevenue = $payments->sum('rental_price');
            $totalDownPayment = $payments->sum('down_payment');
            $totalRemaining = $payments->sum('remaining_cost');

            return $this->successResponse([
                'payments' => OrderResource::collection($payments),
                'total_revenue' => $totalRevenue,
                'total_down_payment' => $totalDownPayment,
                'total_remaining' => $totalRemaining,
                'count' => $payments->count()
            ], 'Daftar pembayaran berhasil dimuat');
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal memuat daftar pembayaran: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Menyelesaikan pembayaran pesanan
     *
     * Endpoint ini digunakan untuk menyelesaikan pembayaran pesanan (pelunasan).
     * Akan mengubah status pesanan menjadi 'approved' dan sisa pembayaran menjadi 0.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function completePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        try {
            $order = Order::findOrFail($request->order_id);

            // Check if the order has remaining balance
            if ($order->remaining_cost <= 0) {
                return $this->errorResponse('Pembayaran sudah lunas', 400);
            }

            // Update the order
            $order->remaining_cost = 0;
            $order->status = 'approved'; // Ensure status is approved
            $order->save();

            return $this->successResponse(
                new OrderResource($order),
                'Pembayaran berhasil dilunasi'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal melunasi pembayaran: ' . $e->getMessage(), 500);
        }
    }
}
