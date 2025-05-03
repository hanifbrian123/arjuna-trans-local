<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('admin.vehicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'license_plate' => 'required|string|max:20|unique:vehicles,license_plate',
            'type' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'facilities' => 'required|string',
            'status' => 'required|in:ready,maintenance',
        ]);

        if (!empty($validated['facilities'])) {
            $validated['facilities'] = explode(',', $validated['facilities']);
        }

        Vehicle::create($validated);

        return redirect()->route('admin.vehicles.index')->with('success', 'Armada berhasil ditambahkan!');
    }

    public function show(Vehicle $vehicle)
    {
        //
    }

    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'license_plate' => "required|string|max:20|unique:vehicles,license_plate,{$vehicle->id}",
            'type' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'facilities' => 'required|string',
            'status' => 'required|in:ready,maintenance',
        ]);

        if (!empty($validated['facilities'])) {
            $validated['facilities'] = explode(',', $validated['facilities']);
        }

        $vehicle->update($validated);

        return redirect()->route('admin.vehicles.index')->with('success', 'Armada berhasil diubah!');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')->with('success', 'Armada berhasil dihapus!');
    }
}
