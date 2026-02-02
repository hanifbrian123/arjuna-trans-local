<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'pickup_address' => 'required|string|max:500',
            'destination' => 'required|string|max:255',
            'route' => 'required|string|max:1000',
            'vehicle_count' => 'required|integer|min:1|max:10',
            'vehicle_type' => 'required|string|max:255',
            'rental_price' => 'required|numeric|min:0',
            'down_payment' => 'nullable|numeric|min:0|lte:rental_price',
            'status' => 'required|in:waiting,approved,canceled',
            'additional_notes' => 'nullable|string|max:1000',
            'vehicle_ids' => 'required|array',
            'vehicle_ids.*' => 'exists:vehicles,id',
            'driver_ids' => 'required|array',
            'driver_ids.*' => 'exists:drivers,id',
        ];

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama pemesan harus diisi',
            'phone_number.required' => 'Nomor telepon harus diisi',
            'address.required' => 'Alamat harus diisi',
            'start_date.required' => 'Tanggal mulai harus diisi',
            'start_date.date' => 'Format tanggal mulai tidak valid',
            'end_date.required' => 'Tanggal selesai harus diisi',
            'end_date.date' => 'Format tanggal selesai tidak valid',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai',
            'pickup_address.required' => 'Alamat penjemputan harus diisi',
            'destination.required' => 'Tujuan harus diisi',
            'route.required' => 'Rute harus diisi',
            'vehicle_count.required' => 'Jumlah kendaraan harus diisi',
            'vehicle_count.integer' => 'Jumlah kendaraan harus berupa angka',
            'vehicle_count.min' => 'Jumlah kendaraan minimal 1',
            'vehicle_count.max' => 'Jumlah kendaraan maksimal 10',
            'vehicle_type.required' => 'Tipe kendaraan harus diisi',
            'rental_price.required' => 'Harga sewa harus diisi',
            'rental_price.numeric' => 'Harga sewa harus berupa angka',
            'rental_price.min' => 'Harga sewa minimal 0',
            'down_payment.numeric' => 'Uang muka harus berupa angka',
            'down_payment.min' => 'Uang muka minimal 0',
            'down_payment.lte' => 'Uang muka tidak boleh lebih dari harga sewa',
            'status.required' => 'Status harus diisi',
            'status.in' => 'Status harus salah satu dari: waiting, approved, canceled',
            'vehicle_ids.required' => 'ID kendaraan harus diisi',
            'vehicle_ids.array' => 'ID kendaraan harus berupa array',
            'vehicle_ids.*.exists' => 'Kendaraan tidak ditemukan',
            'driver_id.exists' => 'Driver tidak ditemukan',
            'driver_id.*.exists' => 'Salah satu driver tidak ditemukan',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Data yang diberikan tidak valid',
            'errors' => $validator->errors()
        ], 422));
    }
}
