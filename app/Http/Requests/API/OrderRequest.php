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
        return [
            'customer_id' => 'required|exists:users,id',
            'pickup_location' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'pickup_date' => 'required|date',
            'pickup_time' => 'required',
            'vehicle_id' => 'required|exists:vehicles,id',
            'total_price' => 'required|numeric',
            'notes' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'customer_id.required' => 'ID pelanggan harus diisi',
            'customer_id.exists' => 'Pelanggan tidak ditemukan',
            'pickup_location.required' => 'Lokasi penjemputan harus diisi',
            'destination.required' => 'Tujuan harus diisi',
            'pickup_date.required' => 'Tanggal penjemputan harus diisi',
            'pickup_date.date' => 'Format tanggal penjemputan tidak valid',
            'pickup_time.required' => 'Waktu penjemputan harus diisi',
            'vehicle_id.required' => 'ID kendaraan harus diisi',
            'vehicle_id.exists' => 'Kendaraan tidak ditemukan',
            'total_price.required' => 'Total harga harus diisi',
            'total_price.numeric' => 'Total harga harus berupa angka',
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
