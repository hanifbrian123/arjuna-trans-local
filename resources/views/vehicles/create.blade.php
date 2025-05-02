@extends('layouts.master')

@section('title', 'Tambah Kendaraan')

@push('styles')
    <!-- dropzone css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/dropzone/dropzone.css') }}" type="text/css" />
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Tambah Kendaraan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.index') }}">Kendaraan</a></li>
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
                    <h5 class="card-title mb-0">Form Tambah Kendaraan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf

                        <div class="row g-3">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama/Model Kendaraan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}"
                                           placeholder="Masukkan nama atau model kendaraan" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">Jenis Kendaraan <span class="text-danger">*</span></label>
                                    <select class="form-control @error('type') is-invalid @enderror" data-choices name="type" id="type" required>
                                        <option value="">Pilih Jenis Kendaraan</option>
                                        <option value="minibus" {{ old('type') == 'minibus' ? 'selected' : '' }}>Minibus</option>
                                        <option value="bus" {{ old('type') == 'bus' ? 'selected' : '' }}>Bus</option>
                                        <option value="car" {{ old('type') == 'car' ? 'selected' : '' }}>Mobil</option>
                                        <option value="elf" {{ old('type') == 'elf' ? 'selected' : '' }}>Elf</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="license_plate" class="form-label">Nomor Polisi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('license_plate') is-invalid @enderror"
                                           id="license_plate" name="license_plate" value="{{ old('license_plate') }}"
                                           placeholder="Contoh: B 1234 ABC" required>
                                    @error('license_plate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="capacity" class="form-label">Kapasitas Penumpang <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('capacity') is-invalid @enderror"
                                           id="capacity" name="capacity" value="{{ old('capacity') }}"
                                           placeholder="Masukkan jumlah kursi" min="1" required>
                                    @error('capacity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="year_of_manufacture" class="form-label">Tahun Pembuatan <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('year_of_manufacture') is-invalid @enderror"
                                           id="year_of_manufacture" name="year_of_manufacture" value="{{ old('year_of_manufacture') }}"
                                           placeholder="Masukkan tahun pembuatan" min="1900" max="{{ date('Y') }}" required>
                                    @error('year_of_manufacture')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status Kendaraan <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" data-choices name="status" id="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Dalam Perawatan</option>
                                        <option value="in-use" {{ old('status') == 'in-use' ? 'selected' : '' }}>Sedang Digunakan</option>
                                        <option value="out-of-service" {{ old('status') == 'out-of-service' ? 'selected' : '' }}>Tidak Layak Pakai</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="daily_rate" class="form-label">Tarif Harian (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('daily_rate') is-invalid @enderror"
                                           id="daily_rate" name="daily_rate" value="{{ old('daily_rate') }}"
                                           placeholder="Masukkan tarif harian" min="0" step="0.01" required>
                                    @error('daily_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="weekly_rate" class="form-label">Tarif Mingguan (Rp)</label>
                                    <input type="number" class="form-control @error('weekly_rate') is-invalid @enderror"
                                           id="weekly_rate" name="weekly_rate" value="{{ old('weekly_rate') }}"
                                           placeholder="Masukkan tarif mingguan" min="0" step="0.01">
                                    @error('weekly_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="monthly_rate" class="form-label">Tarif Bulanan (Rp)</label>
                                    <input type="number" class="form-control @error('monthly_rate') is-invalid @enderror"
                                           id="monthly_rate" name="monthly_rate" value="{{ old('monthly_rate') }}"
                                           placeholder="Masukkan tarif bulanan" min="0" step="0.01">
                                    @error('monthly_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="fuel_type" class="form-label">Jenis Bahan Bakar <span class="text-danger">*</span></label>
                                    <select class="form-control @error('fuel_type') is-invalid @enderror" data-choices name="fuel_type" id="fuel_type" required>
                                        <option value="">Pilih Bahan Bakar</option>
                                        <option value="petrol" {{ old('fuel_type') == 'petrol' ? 'selected' : '' }}>Bensin</option>
                                        <option value="diesel" {{ old('fuel_type') == 'diesel' ? 'selected' : '' }}>Solar</option>
                                        <option value="electric" {{ old('fuel_type') == 'electric' ? 'selected' : '' }}>Listrik</option>
                                        <option value="hybrid" {{ old('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                    </select>
                                    @error('fuel_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="transmission" class="form-label">Transmisi <span class="text-danger">*</span></label>
                                    <select class="form-control @error('transmission') is-invalid @enderror" data-choices name="transmission" id="transmission" required>
                                        <option value="">Pilih Transmisi</option>
                                        <option value="manual" {{ old('transmission') == 'manual' ? 'selected' : '' }}>Manual</option>
                                        <option value="automatic" {{ old('transmission') == 'automatic' ? 'selected' : '' }}>Automatic</option>
                                    </select>
                                    @error('transmission')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="insurance_expiry" class="form-label">Tanggal Kadaluarsa Asuransi <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('insurance_expiry') is-invalid @enderror"
                                           id="insurance_expiry" name="insurance_expiry" value="{{ old('insurance_expiry') }}"
                                           required>
                                    @error('insurance_expiry')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="odometer" class="form-label">Odometer (km) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('odometer') is-invalid @enderror"
                                           id="odometer" name="odometer" value="{{ old('odometer') }}"
                                           placeholder="Masukkan jarak tempuh" min="0" required>
                                    @error('odometer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="color" class="form-label">Warna Kendaraan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('color') is-invalid @enderror"
                                           id="color" name="color" value="{{ old('color') }}"
                                           placeholder="Masukkan warna kendaraan" required>
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi Kendaraan</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description" name="description" rows="4"
                                              placeholder="Masukkan deskripsi kendaraan">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Vehicle Features Section -->
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Fitur Kendaraan</label>
                                    <div class="repeater">
                                        <div data-repeater-list="features">
                                            <div data-repeater-item class="row mb-3">
                                                <div class="col-md-5">
                                                    <input type="text" name="feature_name" class="form-control" placeholder="Nama Fitur" required>
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="text" name="description" class="form-control" placeholder="Deskripsi">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" data-repeater-delete class="btn btn-danger">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" data-repeater-create class="btn btn-info">
                                            <i class="ri-add-line"></i> Tambah Fitur
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Photo Upload Section -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0">Dropzone</h4>
                                        </div><!-- end card header -->

                                        <div class="card-body">
                                            <p class="text-muted">DropzoneJS is an open source library that provides drag’n’drop file uploads with image previews.</p>

                                            <div class="dropzone">
                                                <div class="fallback">
                                                    <input name="file" type="file" multiple="multiple">
                                                </div>
                                                <div class="dz-message needsclick">
                                                    <div class="mb-3">
                                                        <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                                    </div>

                                                    <h4>Drop files here or click to upload.</h4>
                                                </div>
                                            </div>

                                            <ul class="list-unstyled mb-0" id="dropzone-preview">
                                                <li class="mt-2" id="dropzone-preview-list">
                                                    <!-- This is used as the file preview template -->
                                                    <div class="border rounded">
                                                        <div class="d-flex p-2">
                                                            <div class="flex-shrink-0 me-3">
                                                                <div class="avatar-sm bg-light rounded">
                                                                    <img data-dz-thumbnail class="img-fluid rounded d-block" src="assets/images/new-document.png" alt="Dropzone-Image" />
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div class="pt-1">
                                                                    <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                                                    <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                                                    <strong class="error text-danger" data-dz-errormessage></strong>
                                                                </div>
                                                            </div>
                                                            <div class="flex-shrink-0 ms-3">
                                                                <button data-dz-remove class="btn btn-sm btn-danger">Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <!-- end dropzon-preview -->
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    <!-- end card -->
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="col-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <a href="{{ route('vehicles.index') }}" class="btn btn-light">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <!-- dropzone min -->
    <script src="{{ asset('assets/libs/dropzone/dropzone-min.js') }}"></script>
    <!-- jQuery Repeater -->
    <script src="https://cdn.jsdelivr.net/npm/jquery.repeater@1.2.1/jquery.repeater.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Nonaktifkan auto-discovery
            Dropzone.autoDiscover = false;

            // Hapus instance lama jika ada
            if (window.myDropzone) {
                window.myDropzone.destroy();
                delete window.myDropzone;
            }

            // Ambil elemen template preview
            var dropzonePreviewNode = document.querySelector("#dropzone-preview-list");

            if (dropzonePreviewNode) {
                // Simpan innerHTML dari parent (ini adalah string HTML)
                var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;

                // Hapus node asli agar tidak muncul dua kali
                dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);

                // Inisialisasi Dropzone
                window.myDropzone = new Dropzone(".dropzone", {
                    url: "{{ route('vehicles.upload-photo') }}",
                    paramName: "file",
                    maxFiles: 1,
                    maxFilesize: 5, // MB
                    acceptedFiles: "image/*",
                    addRemoveLinks: true,
                    autoProcessQueue: true,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    previewTemplate: previewTemplate, // <-- Harus string HTML
                    previewsContainer: "#dropzone-preview", // <-- Selector CSS valid
                    init: function() {
                        this.on("success", function(file, response) {
                            const photoInput = document.getElementById("photo-input");
                            if (photoInput && response.path) {
                                photoInput.value = response.path;
                            }
                            console.log("Upload success:", response);
                        });

                        this.on("error", function(file, message) {
                            console.error("Upload error:", message);
                            if (file) this.removeFile(file);
                            alert("Upload failed: " + (message.message || message));
                        });

                        this.on("removedfile", function(file) {
                            const photoInput = document.getElementById("photo-input");
                            if (photoInput) {
                                photoInput.value = '';
                            }
                            console.log("File removed");
                        });
                    }
                });
            } else {
                console.error("Preview node not found!");
            }

            // Initialize Repeater for features
            $('.repeater').repeater({
                show: function() {
                    $(this).slideDown();
                },
                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });

            // Form validation
            (function() {
                'use strict';
                var forms = document.querySelectorAll('.needs-validation');
                Array.prototype.slice.call(forms)
                    .forEach(function(form) {
                        form.addEventListener('submit', function(event) {
                            if (!form.checkValidity()) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
            })();
        });
    </script>
@endpush
