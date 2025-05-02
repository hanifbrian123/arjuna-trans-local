@extends('layouts.master')

@section('title', 'Tambah Armada')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Armada</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.index') }}">Armada</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Tambah Armada</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('vehicles.store') }}" method="POST">
                        @csrf

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
                                       value="{{ old('name') }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tipe Armada -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="vehicleTypeInput" class="form-label">Tipe Armada</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text"
                                       id="vehicleTypeInput"
                                       name="type"
                                       class="form-control @error('type') is-invalid @enderror"
                                       placeholder="Masukkan tipe armada (misal: IZUZU ELF LONG)"
                                       value="{{ old('type') }}"
                                       required>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Seat -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="seatsInput" class="form-label">Seat</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="number"
                                       id="seatsInput"
                                       name="capacity"
                                       class="form-control @error('capacity') is-invalid @enderror"
                                       placeholder="Masukkan jumlah seat"
                                       value="{{ old('capacity') }}"
                                       required>
                                @error('capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Fasilitas -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="facilitiesInput" class="form-label">Fasilitas</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text"
                                       id="facilitiesInput"
                                       name="facilities"
                                       class="form-control @error('facilities') is-invalid @enderror"
                                       placeholder="AC;TV;Karaoke;dll."
                                       value="{{ old('facilities') }}"
                                       required>
                                @error('facilities')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="statusSelect" class="form-label">Status</label>
                            </div>
                            <div class="col-lg-9">
                                <select id="statusSelect" name="status" class="form-select @error('status') is-invalid @enderror" data-choices required>
                                    <option value="">Pilih status</option>
                                    <option value="ready" {{ old('status') == 'ready' ? 'selected' : '' }}>Ready</option>
                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="text-end">
                            <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Armada</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
