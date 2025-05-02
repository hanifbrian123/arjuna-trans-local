<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\User;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    /**
     * Display a listing of the drivers.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $drivers = Driver::with('user')->get();

        return response()->json([
            'drivers' => $drivers
        ]);
    }

    /**
     * Store a newly created driver.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'license_number' => 'required|string|max:50',
            'license_expiry' => 'required|date',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            // Assign driver role
            $user->assignRole('driver');

            // Create driver profile
            $driver = Driver::create([
                'user_id' => $user->id,
                'license_number' => $request->license_number,
                'license_expiry' => $request->license_expiry,
                'address' => $request->address,
                'status' => 'active',
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Driver created successfully',
                'driver' => $driver->load('user')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create driver',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified driver.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Driver $driver)
    {
        $driver->load('user');
        
        return response()->json([
            'driver' => $driver
        ]);
    }

    /**
     * Update the specified driver.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Driver $driver)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $driver->user_id,
            'phone' => 'sometimes|required|string|max:20',
            'password' => 'nullable|string|min:8',
            'license_number' => 'sometimes|required|string|max:50',
            'license_expiry' => 'sometimes|required|date',
            'address' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Update user
            $userData = [];
            if ($request->has('name')) $userData['name'] = $request->name;
            if ($request->has('email')) $userData['email'] = $request->email;
            if ($request->has('phone')) $userData['phone'] = $request->phone;
            if ($request->has('password') && $request->password) {
                $userData['password'] = Hash::make($request->password);
            }

            if (!empty($userData)) {
                $driver->user->update($userData);
            }

            // Update driver profile
            $driverData = [];
            if ($request->has('license_number')) $driverData['license_number'] = $request->license_number;
            if ($request->has('license_expiry')) $driverData['license_expiry'] = $request->license_expiry;
            if ($request->has('address')) $driverData['address'] = $request->address;
            if ($request->has('status')) $driverData['status'] = $request->status;

            if (!empty($driverData)) {
                $driver->update($driverData);
            }

            DB::commit();

            return response()->json([
                'message' => 'Driver updated successfully',
                'driver' => $driver->fresh()->load('user')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to update driver',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified driver.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Driver $driver)
    {
        DB::beginTransaction();
        try {
            // Delete driver
            $driver->delete();
            
            // Delete user
            $driver->user->delete();
            
            DB::commit();
            
            return response()->json([
                'message' => 'Driver deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to delete driver',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
