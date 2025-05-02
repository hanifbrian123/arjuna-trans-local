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
                                <label for="capacityInput" class="form-label">Kapasitas (Seat)</label>
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
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="acCheckbox" name="facilities[]" value="AC" {{ in_array('AC', old('facilities', $vehicle->facilities ?? [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="acCheckbox">AC</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="tvCheckbox" name="facilities[]" value="TV" {{ in_array('TV', old('facilities', $vehicle->facilities ?? [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tvCheckbox">TV</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="wifiCheckbox" name="facilities[]" value="WiFi" {{ in_array('WiFi', old('facilities', $vehicle->facilities ?? [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="wifiCheckbox">WiFi</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="toiletCheckbox" name="facilities[]" value="Toilet" {{ in_array('Toilet', old('facilities', $vehicle->facilities ?? [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="toiletCheckbox">Toilet</label>
                                </div>
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
                                    class="form-select @error('status') is-invalid @enderror"
                                    required>
                                    <option value="" disabled>Pilih status</option>
                                    <option value="ready" {{ old('status', $vehicle->status) == 'ready' ? 'selected' : '' }}>Siap</option>
                                    <option value="maintenance" {{ old('status', $vehicle->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    <option value="booked" {{ old('status', $vehicle->status) == 'booked' ? 'selected' : '' }}>Terpesan</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="text-end">
                            <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Foto -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Upload Foto Armada</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.vehicles.upload-photo') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="photoInput" class="form-label">Foto Armada</label>
                            </div>
                            <div class="col-lg-9">
                                @if($vehicle->photo)
                                    <div class="mb-3">
                                        <img src="{{ asset($vehicle->photo) }}" alt="{{ $vehicle->name }}" class="img-thumbnail" style="max-height: 200px;">
                                    </div>
                                @endif
                                <input type="file"
                                       id="photoInput"
                                       name="photo"
                                       class="form-control @error('photo') is-invalid @enderror"
                                       accept="image/*"
                                       required>
                                <small class="text-muted">Format: JPG, PNG, GIF. Maks: 2MB</small>
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Upload Foto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
