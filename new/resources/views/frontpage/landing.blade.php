@extends('layouts.master_landing')

@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('customer.saveCust') }}" method="POST">
                        @csrf
                        <!-- Nama Pemesan -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="nameInput" class="form-label">NAMA PEMESAN (WAJIB)</label>
                                    <input type="text" id="nameInput" name="name" class="form-control" placeholder="Masukkan nama pemesan" required>
                                </div>
                            </div>
                            <!-- Nomor Telepon -->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="phoneInput" class="form-label">NO.WHATSAPP (WAJIB)</label>
                                    <input type="number" id="phoneInput" name="phone_number" class="form-control" placeholder="Masukkan nomor telepon" required>
                                </div>
                            </div>
                        </div>


                        <!-- Alamat -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="addressInput" class="form-label">ALAMAT PEMESAN (WAJIB)</label>
                                    <textarea id="addressInput" name="address" class="form-control" placeholder="Masukkan alamat lengkap" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Tanggal Pakai -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="startDateInput" class="form-label">WAKTU KEBERANGKATAN <span class="text-muted">(yyyy-mm-dd hh:mm)</span></label>
                                    <input type="datetime-local" id="startDateInput" name="start_date" class="form-control" required placeholder="Tanggal - Waktu Keberangkatan">
                                </div>
                            </div>
                            <!-- Tanggal Selesai -->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="endDateInput" class="form-label">WAKTU TIBA KEMBALI <span class="text-muted">(yyyy-mm-dd hh:mm)</span></label>
                                    <input type="datetime-local" id="endDateInput" name="end_date" class="form-control" required placeholder="Tanggal - Waktu Tiba">
                                </div>
                            </div>
                        </div>

                        <!-- Alamat Penjemputan -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="pickupAddressInput" class="form-label">ALAMAT PENJEMPUTAN (WAJIB)</label>
                                    <textarea id="pickupAddressInput" name="pickup_address" class="form-control" placeholder="Masukkan alamat penjemputan" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Tujuan -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="destinationInput" class="form-label">TUJUAN UTAMA (WAJIB)</label>
                                    <input type="text" id="destinationInput" name="destination" class="form-control" placeholder="Masukkan tujuan utama" required>
                                </div>
                            </div>
                        </div>

                        <!-- Rute -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="routeInput" class="form-label">RUTE TUJUAN (WAJIB)</label>
                                    <textarea id="routeInput" name="route" class="form-control" placeholder="Masukkan rute perjalanan" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Armada -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="vehicleIdsInput" class="form-label">PILIH ARMADA (WAJIB) <small class="text-muted">Pilih satu atau lebih armada</small></label>
                                    <select id="vehicleIdsInput" name="vehicle_ids[]" class="form-select" data-choices data-choices-removeItem multiple required>
                                        <option value="">Pilih Armada</option>
                                        @foreach ($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}">{{ $vehicle->name }} - {{ $vehicle->type }} ({{ $vehicle->capacity }} Seat)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Driver Pilihan -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="driverIdsInput" class="form-label">PILIH DRIVER (OPSIONAL) <small class="text-muted">Pilih satu atau lebih driver</small></label>
                                    <select id="driverIdsInput" name="driver_ids[]" class="form-select" data-choices data-choices-removeItem multiple required>
                                        <option value="">Pilih Driver</option>
                                        @foreach ($drivers as $driver)
                                            <option value="{{ $driver->id }}">{{ $driver->user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="text-center">

                            <button type="submit" class="btn btn-lg rounded-pill" title="Klik untuk memesan sekarang"
                                style="background-color: #ff7f00; color: white; border: none; padding: 10px 30px;">
                            Pesan Sekarang
                            </button>                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script>
        (z = document.querySelectorAll("[data-choices]")),
        Array.from(z).forEach(function (e) {
            var t = {},
                a = e.attributes;
            a["data-choices-groups"] &&
                (t.placeholderValue =
                    "This is a placeholder set in the config"),
                a["data-choices-search-false"] && (t.searchEnabled = !1),
                a["data-choices-search-true"] && (t.searchEnabled = !0),
                a["data-choices-removeItem"] && (t.removeItemButton = !0),
                a["data-choices-sorting-false"] && (t.shouldSort = !1),
                a["data-choices-sorting-true"] && (t.shouldSort = !0),
                a["data-choices-multiple-remove"] && (t.removeItemButton = !0),
                a["data-choices-limit"] &&
                    (t.maxItemCount = a["data-choices-limit"].value.toString()),
                a["data-choices-limit"] &&
                    (t.maxItemCount = a["data-choices-limit"].value.toString()),
                a["data-choices-editItem-true"] && (t.maxItemCount = !0),
                a["data-choices-editItem-false"] && (t.maxItemCount = !1),
                a["data-choices-text-unique-true"] &&
                    (t.duplicateItemsAllowed = !1),
                a["data-choices-text-disabled-true"] && (t.addItems = !1),
                a["data-choices-text-disabled-true"]
                    ? new Choices(e, t).disable()
                    : new Choices(e, t);
        });        

    </script>
    <!-- Global Alert Component -->
    <x-alert />
@endsection
