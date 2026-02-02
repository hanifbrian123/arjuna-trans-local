@extends('layouts.master')

@section('title', 'Edit Armada')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Armada</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.vehicles.index') }}">Armada</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Edit Armada</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.vehicles.update', $vehicle->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nama Armada -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="nameInput" class="form-label">Nama Armada</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text"
                                       id="nameInput"
                                       name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Masukkan nama armada"
                                       value="{{ old('name', $vehicle->name) }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Nomor Polisi -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="licensePlateInput" class="form-label">Nomor Polisi</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text"
                                       id="licensePlateInput"
                                       name="license_plate"
                                       class="form-control @error('license_plate') is-invalid @enderror"
                                       placeholder="Masukkan nomor polisi"
                                       value="{{ old('license_plate', $vehicle->license_plate) }}"
                                       required>
                                @error('license_plate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tipe Armada -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="typeInput" class="form-label">Tipe Armada</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text"
                                       id="typeInput"
                                       name="type"
                                       class="form-control @error('type') is-invalid @enderror"
                                       placeholder="Masukkan tipe armada"
                                       value="{{ old('type', $vehicle->type) }}"
                                       required>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kapasitas -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="capacityInput" class="form-label">Seat</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="number"
                                       id="capacityInput"
                                       name="capacity"
                                       class="form-control @error('capacity') is-invalid @enderror"
                                       placeholder="Masukkan jumlah seat"
                                       value="{{ old('capacity', $vehicle->capacity) }}"
                                       min="1"
                                       required>
                                @error('capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Fasilitas -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label class="form-label">Fasilitas</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text"
                                       id="facilitiesInput"
                                       name="facilities"
                                       class="form-control @error('facilities') is-invalid @enderror"
                                       placeholder="Masukkan fasilitas (pisahkan dengan koma)""
                                       value="{{ old('facilities', implode(', ', $vehicle->facilities)) }}"
                                       required>
                                @error('facilities')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="statusInput" class="form-label">Status</label>
                            </div>
                            <div class="col-lg-9">
                                <select
                                        id="statusInput"
                                        name="status"
                                        class="form-select @error('status') is-invalid @enderror" data-choices
                                        required>
                                    <option value="" disabled>Pilih status</option>
                                    <option value="ready" {{ old('status', $vehicle->status) == 'ready' ? 'selected' : '' }}>Ready</option>
                                    <option value="maintenance" {{ old('status', $vehicle->status) == 'maintenance' ? 'selected' : '' }}>Service</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="text-end">
                            <a href="{{ route('admin.vehicles.index') }}" class="btn btn-default" style="background-color: #6c757d !important;color: #fff !important" title="Klik untuk kembali">Kembali</a>
                            <button type="submit" class="btn btn-primary" title="Klik untuk simpan">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
