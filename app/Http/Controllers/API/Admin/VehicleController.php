<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Vehicle;
use App\Traits\ApiResponser;
use App\Http\Resources\VehicleResource;
use App\Http\Requests\API\VehicleRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

/**
 * @group Pengelolaan Armada
 *
 * API untuk mengelola data armada kendaraan
 */
class VehicleController extends Controller
{
    use ApiResponser;

    /**
     * Menampilkan daftar armada
     *
     * Endpoint ini digunakan untuk mendapatkan daftar semua armada kendaraan.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $vehicles = Vehicle::all();

        return $this->successResponse(
            VehicleResource::collection($vehicles),
            'Daftar armada berhasil dimuat'
        );
    }

    /**
     * Menyimpan armada baru
     *
     * Endpoint ini digunakan untuk membuat data armada kendaraan baru.
     *
     * @param  \App\Http\Requests\API\VehicleRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(VehicleRequest $request)
    {
        try {
            $vehicle = Vehicle::create($request->validated());

            return $this->successResponse(
                new VehicleResource($vehicle),
                'Armada berhasil dibuat',
                201
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal membuat armada: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Menampilkan detail armada
     *
     * Endpoint ini digunakan untuk mendapatkan detail data armada kendaraan berdasarkan ID.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Vehicle $vehicle)
    {
        return $this->successResponse(
            new VehicleResource($vehicle),
            'Detail armada berhasil dimuat'
        );
    }

    /**
     * Memperbarui data armada
     *
     * Endpoint ini digunakan untuk memperbarui data armada kendaraan yang sudah ada.
     *
     * @param  \App\Http\Requests\API\VehicleRequest  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(VehicleRequest $request, Vehicle $vehicle)
    {
        try {
            $vehicle->update($request->validated());

            return $this->successResponse(
                new VehicleResource($vehicle->fresh()),
                'Armada berhasil diperbarui'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal memperbarui armada: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Menghapus armada
     *
     * Endpoint ini digunakan untuk menghapus data armada kendaraan.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Vehicle $vehicle)
    {
        try {
            $vehicle->delete();

            return $this->successResponse(
                null,
                'Armada berhasil dihapus'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal menghapus armada: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Mengunggah foto armada
     *
     * Endpoint ini digunakan untuk mengunggah foto armada kendaraan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadPhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|exists:vehicles,id',
            'photo' => 'required|image|max:2048', // Max 2MB
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        try {
            $vehicle = Vehicle::findOrFail($request->vehicle_id);

            if ($request->hasFile('photo')) {
                // Add photo to media library
                $media = $vehicle->addMediaFromRequest('photo')
                    ->toMediaCollection('photos');

                return $this->successResponse([
                    'vehicle' => new VehicleResource($vehicle),
                    'media' => [
                        'id' => $media->id,
                        'url' => $media->getFullUrl(),
                        'file_name' => $media->file_name,
                    ]
                ], 'Foto armada berhasil diunggah');
            }

            return $this->errorResponse('Tidak ada foto yang diunggah', 400);
        } catch (\Exception $e) {
            return $this->errorResponse('Gagal mengunggah foto: ' . $e->getMessage(), 500);
        }
    }
}
