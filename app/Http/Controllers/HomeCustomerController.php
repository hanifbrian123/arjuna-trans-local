<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Order;
class HomeCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function formCust()
    {
        $vehicles = Vehicle::where('status', 'ready')->get();
        $drivers = Driver::where('status', 'active')->get();

        return view('frontpage.landing', compact('vehicles', 'drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function saveCust(Request $request)
    {
        // return $request;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'pickup_address' => 'required|string|max:500',
            'destination' => 'required|string|max:255',
            'route' => 'required|string|max:1000',
            'vehicle_ids' => 'required|array',
            'vehicle_ids.*' => 'exists:vehicles,id',
            'driver_ids' => 'required|array',
            'driver_ids.*' => 'exists:drivers,id',
        ], [
            'vehicle_count.max' => 'Jumlah armada maksimal 10 unit.',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
            'vehicle_ids.required' => 'Pilih minimal satu armada.',
            'driver_ids.required' => 'Pilih minimal satu driver.',
        ]);

        $validated['rental_price'] = 0;
        $validated['down_payment'] = 0;
        $validated['remaining_cost'] = 0;                

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
        return redirect(url('customer'))->with('success', 'Pesanan Anda berhasil dibuat!');        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
