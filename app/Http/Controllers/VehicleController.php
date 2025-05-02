<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->datatables();
        }

        return view('vehicles.index');
    }

    public function datatables()
    {
        $vehicles = Vehicle::all();

        return DataTables::of($vehicles)
            ->addIndexColumn()
            ->toJson();
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'capacity' => 'required',
            'facilities' => 'required',
            'status' => 'required',
        ]);

        Vehicle::create($validated);

        return redirect()->route('vehicles.index')->with('success', 'Armada berhasil ditambahkan!');
    }

    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'capacity' => 'required',
            'facilities' => 'required',
            'status' => 'required',
        ]);

        $vehicle->update($validated);

        return redirect()->route('vehicles.index')->with('success', 'Armada berhasil diubah!');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index')->with('success', 'Armada berhasil dihapus!');
    }
}
