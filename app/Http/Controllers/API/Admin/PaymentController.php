<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Order;
use App\Traits\ApiResponser;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
     * Dapat difilter berdasarkan rentang tanggal dan driver.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $query = Order::with(['user', 'driver', 'vehicle'])
                ->where('status', 'approved');

            // Filter by date range if provided
            if ($request->has('start_date') && $request->has('end_date')) {
                $query->whereBetween('pickup_date', [$request->start_date, $request->end_date]);
            }

            // Filter by driver if provided
            if ($request->has('driver_id')) {
                $query->where('driver_id', $request->driver_id);
            }

            $payments = $query->get();

            // Calculate total revenue
            $totalRevenue = $payments->sum('total_price');

            return $this->successResponse([
                'payments' => OrderResource::collection($payments),
                'total_revenue' => $totalRevenue,
                'count' => $payments->count()
            ], 'Daftar pembayaran berhasil dimuat');
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal memuat daftar pembayaran: ' . $e->getMessage(), 500);
        }
    }
}
