@extends('layouts.master')

@section('title', 'Tambah Driver')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Driver</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.drivers.index') }}">Driver</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Tambah Driver</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.drivers.store') }}" method="POST">
                        @csrf

                        <!-- Informasi Akun -->
                        <h5 class="mb-3">Informasi Akun</h5>

                        <!-- Nama -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="nameInput" class="form-label">Nama</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text"
                                       id="nameInput"
                                       name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Masukkan nama driver"
                                       value="{{ old('name') }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="emailInput" class="form-label">Email</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="email"
                                       id="emailInput"
                                       name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="Masukkan email driver"
                                       value="{{ old('email') }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="passwordInput" class="form-label">Password</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="password"
                                       id="passwordInput"
                                       name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Masukkan password"
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Informasi Driver -->
                        <h5 class="mb-3 mt-4">Informasi Driver</h5>

                        <!-- Alamat -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="addressInput" class="form-label">Alamat</label>
                            </div>
                            <div class="col-lg-9">
                                <textarea
                                    id="addressInput"
                                    name="address"
                                    class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Masukkan alamat lengkap"
                                    rows="3"
                                    required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="phoneInput" class="form-label">Nomor Telepon</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text"
                                       id="phoneInput"
                                       name="phone_number"
                                       class="form-control @error('phone_number') is-invalid @enderror"
                                       placeholder="Masukkan nomor telepon"
                                       value="{{ old('phone_number') }}"
                                       required>
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tipe SIM -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="licenseTypeInput" class="form-label">Tipe SIM</label>
                            </div>
                            <div class="col-lg-9">
                                <select
                                    id="licenseTypeInput"
                                    name="license_type"
                                    class="form-select @error('license_type') is-invalid @enderror"
                                    required>
                                    <option value="" disabled selected>Pilih tipe SIM</option>
                                    <option value="A" {{ old('license_type') == 'A' ? 'selected' : '' }}>SIM A</option>
                                    <option value="B" {{ old('license_type') == 'B' ? 'selected' : '' }}>SIM B</option>
                                    <option value="C" {{ old('license_type') == 'C' ? 'selected' : '' }}>SIM C</option>
                                    <option value="D" {{ old('license_type') == 'D' ? 'selected' : '' }}>SIM D</option>
                                    <option value="E" {{ old('license_type') == 'E' ? 'selected' : '' }}>SIM E</option>
                                </select>
                                @error('license_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
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
                                    <option value="" disabled selected>Pilih status</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="notesInput" class="form-label">Catatan</label>
                            </div>
                            <div class="col-lg-9">
                                <textarea
                                    id="notesInput"
                                    name="notes"
                                    class="form-control @error('notes') is-invalid @enderror"
                                    placeholder="Masukkan catatan (opsional)"
                                    rows="3">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="text-end">
                            <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
