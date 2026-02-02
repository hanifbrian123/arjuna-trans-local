<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\User;
use App\Models\Driver;
use App\Traits\ApiResponser;
use App\Http\Resources\DriverResource;
use App\Http\Requests\API\DriverRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

/**
 * @group Pengelolaan Driver
 *
 * API untuk mengelola data driver
 */
class DriverController extends Controller
{
    use ApiResponser;

    /**
     * Menampilkan daftar driver
     *
     * Endpoint ini digunakan untuk mendapatkan daftar semua driver.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $drivers = Driver::with('user')->get();

        return $this->successResponse(
            DriverResource::collection($drivers),
            'Daftar driver berhasil dimuat'
        );
    }

    /**
     * Menyimpan driver baru
     *
     * Endpoint ini digunakan untuk membuat data driver baru.
     *
     * @param  \App\Http\Requests\API\DriverRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DriverRequest $request)
    {
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
                'address' => $request->address,
                'status' => 'active',
            ]);

            DB::commit();

            return $this->successResponse(
                new DriverResource($driver->load('user')),
                'Driver berhasil dibuat',
                201
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Gagal membuat driver: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Menampilkan detail driver
     *
     * Endpoint ini digunakan untuk mendapatkan detail data driver berdasarkan ID.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Driver $driver)
    {
        $driver->load('user');

        return $this->successResponse(
            new DriverResource($driver),
            'Detail driver berhasil dimuat'
        );
    }

    /**
     * Memperbarui data driver
     *
     * Endpoint ini digunakan untuk memperbarui data driver yang sudah ada.
     *
     * @param  \App\Http\Requests\API\DriverRequest  $request
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DriverRequest $request, Driver $driver)
    {
        DB::beginTransaction();
        try {
            // Update user
            $userData = [];
            if ($request->has('name'))
                $userData['name'] = $request->name;
            if ($request->has('email'))
                $userData['email'] = $request->email;
            if ($request->has('phone'))
                $userData['phone'] = $request->phone;
            if ($request->has('password') && $request->password) {
                $userData['password'] = Hash::make($request->password);
            }

            if (!empty($userData)) {
                $driver->user->update($userData);
            }

            // Update driver profile
            $driverData = [];
            if ($request->has('address'))
                $driverData['address'] = $request->address;
            if ($request->has('status'))
                $driverData['status'] = $request->status;

            if (!empty($driverData)) {
                $driver->update($driverData);
            }

            DB::commit();

            return $this->successResponse(
                new DriverResource($driver->fresh()->load('user')),
                'Driver berhasil diperbarui'
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Gagal memperbarui driver: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Menghapus driver
     *
     * Endpoint ini digunakan untuk menghapus data driver.
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

            return $this->successResponse(
                null,
                'Driver berhasil dihapus'
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Gagal menghapus driver: ' . $e->getMessage(), 500);
        }
    }
}
