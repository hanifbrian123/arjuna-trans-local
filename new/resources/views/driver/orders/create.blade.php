@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Buat Order Baru</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('driver.orders.index') }}">Order</a></li>
                        <li class="breadcrumb-item active">Buat Order</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Tambah Order</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('driver.orders.store') }}" method="POST">
                        @csrf

                        <!-- Nama Pemesan (Default to driver's name) -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="nameInput" class="form-label">Nama Pemesan</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text"
                                       id="nameInput"
                                       name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Masukkan nama pemesan"
                                       value="{{ old('name', auth()->user()->name) }}"
                                       required>
                                @error('name')
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
                                       value="{{ old('phone_number', auth()->user()->phone) }}"
                                       required>
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="addressInput" class="form-label">Alamat</label>
                            </div>
                            <div class="col-lg-9">
                                <textarea id="addressInput"
                                          name="address"
                                          class="form-control @error('address') is-invalid @enderror"
                                          placeholder="Masukkan alamat"
                                          rows="3"
                                          required>{{ old('address', $driver->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tanggal Mulai -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="startDateInput" class="form-label">Tanggal Mulai</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text"
                                       id="startDateInput"
                                       name="start_date"
                                       class="form-control @error('start_date') is-invalid @enderror"
                                       data-provider="flatpickr"
                                       data-date-format="Y-m-d H:i:S"
                                       data-enable-time="true"
                                       data-time-24hr="true"
                                       placeholder="Pilih tanggal dan waktu mulai"
                                       value="{{ old('start_date') }}"
                                       required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tanggal Selesai -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="endDateInput" class="form-label">Tanggal Selesai</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text"
                                       id="endDateInput"
                                       name="end_date"
                                       class="form-control @error('end_date') is-invalid @enderror"
                                       data-provider="flatpickr"
                                       data-date-format="Y-m-d H:i:S"
                                       data-enable-time="true"
                                       data-time-24hr="true"
                                       placeholder="Pilih tanggal dan waktu selesai"
                                       value="{{ old('end_date') }}"
                                       required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Alamat Penjemputan -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="pickupAddressInput" class="form-label">Alamat Penjemputan</label>
                            </div>
                            <div class="col-lg-9">
                                <textarea id="pickupAddressInput"
                                          name="pickup_address"
                                          class="form-control @error('pickup_address') is-invalid @enderror"
                                          placeholder="Masukkan alamat penjemputan"
                                          rows="3"
                                          required>{{ old('pickup_address') }}</textarea>
                                @error('pickup_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tujuan -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="destinationInput" class="form-label">Tujuan</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text"
                                       id="destinationInput"
                                       name="destination"
                                       class="form-control @error('destination') is-invalid @enderror"
                                       placeholder="Masukkan tujuan"
                                       value="{{ old('destination') }}"
                                       required>
                                @error('destination')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Rute -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="routeInput" class="form-label">Rute</label>
                            </div>
                            <div class="col-lg-9">
                                <textarea id="routeInput"
                                          name="route"
                                          class="form-control @error('route') is-invalid @enderror"
                                          placeholder="Masukkan rute perjalanan"
                                          rows="3"
                                          required>{{ old('route') }}</textarea>
                                @error('route')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Jumlah Kendaraan -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="vehicleCountInput" class="form-label">Jumlah Kendaraan</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="number"
                                       id="vehicleCountInput"
                                       name="vehicle_count"
                                       class="form-control @error('vehicle_count') is-invalid @enderror"
                                       placeholder="Masukkan jumlah kendaraan"
                                       value="{{ old('vehicle_count', 1) }}"
                                       min="1"
                                       max="10"
                                       required>
                                @error('vehicle_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Armada -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="vehicleIdsInput" class="form-label">Armada</label>
                            </div>
                            <div class="col-lg-9">
                                <select id="vehicleIdsInput"
                                        name="vehicle_ids[]"
                                        class="form-select @error('vehicle_ids') is-invalid @enderror"
                                        data-choices data-choices-removeItem multiple
                                        required>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}"
                                                {{ is_array(old('vehicle_ids')) && in_array($vehicle->id, old('vehicle_ids')) ? 'selected' : '' }}>
                                            {{ $vehicle->name }} - {{ $vehicle->type }} ({{ $vehicle->capacity }} Seat)
                                        </option>
                                    @endforeach
                                </select>
                                @error('vehicle_ids')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Pilih satu atau lebih armada</small>
                            </div>
                        </div>

                        <!-- Hidden Rental Price Field -->
                        <input type="hidden" id="rentalPriceInput" name="rental_price" value="0">

                        <!-- Hidden Remaining Cost Field -->
                        <input type="hidden" id="remainingCostInput" name="remaining_cost" value="0">

                        <!-- Down Payment (Uang Muka) -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="downPaymentInput" class="form-label">Uang Muka</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text"
                                       id="downPaymentInput"
                                       name="down_payment"
                                       class="form-control @error('down_payment') is-invalid @enderror"
                                       placeholder="Rp - Masukkan jumlah DP"
                                       value="{{ old('down_payment') }}"
                                       min="0"
                                       required>
                                @error('down_payment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status (Hidden, always waiting) -->
                        <input type="hidden" name="status" value="waiting">

                        <!-- Catatan Tambahan -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="additionalNotesInput" class="form-label">Catatan Tambahan</label>
                            </div>
                            <div class="col-lg-9">
                                <textarea id="additionalNotesInput"
                                          name="additional_notes"
                                          class="form-control @error('additional_notes') is-invalid @enderror"
                                          placeholder="Masukkan catatan tambahan"
                                          rows="3">{{ old('additional_notes') }}</textarea>
                                @error('additional_notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <a href="{{ route('driver.orders.index') }}" class="btn btn-default" style="background-color: #6c757d !important;color: #fff !important" title="Klik untuk kembali">Kembali</a>
                                    <button type="submit" class="btn btn-primary" title="Klik untuk simpan">Simpan</button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('startDateInput');
            const endDateInput = document.getElementById('endDateInput');

            // Setup flatpickr instances with proper configuration
            const startDateFlatpickr = flatpickr(startDateInput, {
                enableTime: true,
                dateFormat: "Y-m-d H:i:S",
                time_24hr: true,
                onChange: function(selectedDates, dateStr) {
                    // When start date changes, update end date min date
                    if (selectedDates.length > 0) {
                        const endDateInstance = endDateInput._flatpickr;
                        if (endDateInstance) {
                            endDateInstance.set('minDate', selectedDates[0]);

                            // If end date is before start date, update it
                            if (endDateInstance.selectedDates.length > 0 &&
                                endDateInstance.selectedDates[0] < selectedDates[0]) {
                                // Set end date to start date + 1 hour
                                const newEndDate = new Date(selectedDates[0]);
                                newEndDate.setHours(newEndDate.getHours() + 1);
                                endDateInstance.setDate(newEndDate);
                            }
                        }
                    }
                }
            });

            flatpickr(endDateInput, {
                enableTime: true,
                dateFormat: "Y-m-d H:i:S",
                time_24hr: true,
                // Set min date to start date if available
                minDate: startDateFlatpickr.selectedDates.length > 0 ? startDateFlatpickr.selectedDates[0] : null
            });

           // FORMAT RUPIAH
            const dpInput = document.getElementById('downPaymentInput');        

            function formatRupiah(angka, prefix = 'Rp ') {
                let number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix + rupiah;
            }

            function parseRupiah(rp) {
                return parseInt(rp.replace(/[^0-9]/g, '')) || 0;
            }

            function updateFormattedInputs() {
                dpInput.value = formatRupiah(parseRupiah(dpInput.value).toString());
                const dp = parseRupiah(dpInput.value);
            }

            // Event listener hanya untuk dpInput
            ['keyup', 'change'].forEach(event => {
                dpInput.addEventListener(event, updateFormattedInputs);
            });

        });
    </script>
@endpush
