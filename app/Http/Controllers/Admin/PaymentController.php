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
        
        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
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
}
