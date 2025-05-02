<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::latest()->paginate(10);
        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'license_plate' => 'required|string|unique:vehicles|regex:/^[A-Z]{1,2}\s*\d{1,4}\s*[A-Z]{1,3}$/',
            'capacity' => 'required|integer|min:1|max:50',
            'status' => 'required|in:available,maintenance,booked',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string|max:1000',
        ], [
            'license_plate.regex' => 'Format nomor polisi tidak valid. Contoh: B 1234 ABC',
            'photo.max' => 'Ukuran foto tidak boleh lebih dari 2MB',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('vehicles', 'public');
            $validated['photo'] = $path;
        }

        Vehicle::create($validated);

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Kendaraan berhasil ditambahkan');
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
            'name' => 'required|string|max:255',
            'license_plate' => 'required|string|unique:vehicles,license_plate,' . $vehicle->id . '|regex:/^[A-Z]{1,2}\s*\d{1,4}\s*[A-Z]{1,3}$/',
            'capacity' => 'required|integer|min:1|max:50',
            'status' => 'required|in:available,maintenance,booked',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string|max:1000',
        ], [
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($vehicle->photo) {
                Storage::disk('public')->delete($vehicle->photo);
            }

            $path = $request->file('photo')->store('vehicles', 'public');
            $validated['photo'] = $path;
        }

        $vehicle->update($validated);

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Kendaraan berhasil diperbarui');
    }

    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->photo) {
            Storage::disk('public')->delete($vehicle->photo);
        }

        $vehicle->delete();

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Kendaraan berhasil dihapus');
    }

    public function uploadPhoto(Request $request)
    {
        $path = storage_path('tmp/uploads');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name' => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }
}


