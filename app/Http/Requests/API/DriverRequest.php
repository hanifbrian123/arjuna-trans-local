<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DriverRequest extends FormRequest
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
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'license_number' => 'required|string|max:50',
            'license_expiry' => 'required|date',
            'license_type' => 'required|in:A,B,C,D,E',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string',
        ];

        if ($this->isMethod('post')) {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|min:6';
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['email'] = 'sometimes|required|email|unique:users,email,' . $this->driver->user_id;
            $rules['password'] = 'nullable|min:6';
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
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'phone.required' => 'Nomor telepon harus diisi',
            'address.required' => 'Alamat harus diisi',
            'license_number.required' => 'Nomor SIM harus diisi',
            'license_expiry.required' => 'Tanggal kadaluarsa SIM harus diisi',
            'license_expiry.date' => 'Format tanggal kadaluarsa SIM tidak valid',
            'license_type.required' => 'Tipe SIM harus diisi',
            'license_type.in' => 'Tipe SIM harus salah satu dari: A, B, C, D, E',
            'status.required' => 'Status harus diisi',
            'status.in' => 'Status harus salah satu dari: active, inactive',
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
