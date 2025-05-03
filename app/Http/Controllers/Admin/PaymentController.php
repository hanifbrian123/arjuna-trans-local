<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        // Filter by date range if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by payment status if provided
        if ($request->has('payment_status') && $request->payment_status) {
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

        // Only include approved and waiting orders
        $query->whereIn('status', ['approved', 'waiting']);

        // Get orders with payment information
        $orders = $query->get();

        // Calculate totals
        $totalRevenue = $orders->sum('rental_price');
        $totalDownPayment = $orders->sum('down_payment');
        $totalRemaining = $orders->sum('remaining_cost');

        return view('admin.payments.index', compact(
            'orders',
            'totalRevenue',
            'totalDownPayment',
            'totalRemaining'
        ));
    }

    /**
     * Complete the payment for an order
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function complete(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        try {
            $order = Order::findOrFail($request->order_id);

            // Check if the order has remaining balance
            if ($order->remaining_cost <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembayaran sudah lunas'
                ], 400);
            }

            // Update the order
            $order->remaining_cost = 0;
            $order->status = 'approved'; // Ensure status is approved
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil dilunasi',
                'order' => $order
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
