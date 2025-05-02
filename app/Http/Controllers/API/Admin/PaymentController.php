<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'driver', 'vehicle'])
            ->where('status', 'completed');

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

        return response()->json([
            'payments' => $payments,
            'total_revenue' => $totalRevenue,
            'count' => $payments->count()
        ]);
    }
}
