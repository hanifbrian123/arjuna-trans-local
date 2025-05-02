<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::with('user')->get();
        return view('admin.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('admin.drivers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'address' => 'required',
            'phone_number' => 'required',
            'license_type' => 'required|in:A,B,C,D,E',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable',
        ]);

        // Create user first
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone' => $validated['phone_number'],
        ]);

        // Assign driver role
        $user->assignRole('driver');

        // Create driver profile
        $driver = Driver::create([
            'user_id' => $user->id,
            'address' => $validated['address'],
            'phone_number' => $validated['phone_number'],
            'license_type' => $validated['license_type'],
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.drivers.index')->with('success', 'Driver berhasil ditambahkan!');
    }

    public function show(Driver $driver)
    {
        return view('admin.drivers.show', compact('driver'));
    }

    public function edit(Driver $driver)
    {
        return view('admin.drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $driver->user_id,
            'password' => 'nullable|min:6',
            'address' => 'required',
            'phone_number' => 'required',
            'license_type' => 'required|in:A,B,C,D,E',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable',
        ]);

        // Update user
        $user = $driver->user;
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone_number'];

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        // Update driver profile
        $driver->update([
            'address' => $validated['address'],
            'phone_number' => $validated['phone_number'],
            'license_type' => $validated['license_type'],
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.drivers.index')->with('success', 'Driver berhasil diubah!');
    }

    public function destroy(Driver $driver)
    {
        // Delete the user (will cascade delete the driver due to foreign key constraint)
        $driver->user->delete();

        return redirect()->route('admin.drivers.index')->with('success', 'Driver berhasil dihapus!');
    }
}
