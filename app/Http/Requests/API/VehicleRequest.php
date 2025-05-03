<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VehicleRequest extends FormRequest
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
            'type' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1',
            'facilities' => 'nullable|array',
            'status' => 'required|in:ready,maintenance,booked',
        ];

        if ($this->isMethod('post')) {
            $rules['license_plate'] = 'required|string|max:20|unique:vehicles,license_plate';
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['license_plate'] = 'sometimes|required|string|max:20|unique:vehicles,license_plate,' . $this->vehicle->id;
        }

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
            'name.required' => 'Nama kendaraan harus diisi',
            'type.required' => 'Tipe kendaraan harus diisi',
            'license_plate.required' => 'Plat nomor harus diisi',
            'license_plate.unique' => 'Plat nomor sudah digunakan',
            'capacity.required' => 'Kapasitas harus diisi',
            'capacity.integer' => 'Kapasitas harus berupa angka',
            'capacity.min' => 'Kapasitas minimal 1',
            'status.required' => 'Status harus diisi',
            'status.in' => 'Status harus salah satu dari: ready, maintenance, booked',
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
