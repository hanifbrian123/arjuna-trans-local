@extends('layouts.master')

@section('title', 'Edit Order')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Order</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Order</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card main-page">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Edit Order</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nama Pemesan -->
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
                                       value="{{ old('name', $order->name) }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="phoneInput" class="form-label">Nomor WhatsApp</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text"
                                       id="phoneInput"
                                       name="phone_number"
                                       class="form-control @error('phone_number') is-invalid @enderror"
                                       placeholder="Masukkan nomor telepon"
                                       value="{{ old('phone_number', $order->phone_number) }}"
                                       required>
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="addressInput" class="form-label">Alamat Pemesan</label>
                            </div>
                            <div class="col-lg-9">
                                <textarea
                                          id="addressInput"
                                          name="address"
                                          class="form-control @error('address') is-invalid @enderror"
                                          placeholder="Masukkan alamat lengkap"
                                          rows="3"
                                          required>{{ old('address', $order->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <!-- Tanggal Mulai -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="startDateInput" class="form-label">Tanggal Mulai</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="datetime-local"
                                       id="startDateInput"
                                       name="start_date"
                                       class="form-control @error('start_date') is-invalid @enderror"
                                       value="{{ old('start_date', $order->start_date->format('Y-m-d\TH:i')) }}"
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
                                <input type="datetime-local"
                                       id="endDateInput"
                                       name="end_date"
                                       class="form-control @error('end_date') is-invalid @enderror"
                                       value="{{ old('end_date', $order->end_date->format('Y-m-d\TH:i')) }}"
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
                                <textarea
                                          id="pickupAddressInput"
                                          name="pickup_address"
                                          class="form-control @error('pickup_address') is-invalid @enderror"
                                          placeholder="Masukkan alamat penjemputan"
                                          rows="3"
                                          required>{{ old('pickup_address', $order->pickup_address) }}</textarea>
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
                                       placeholder="Masukkan tujuan utama"
                                       value="{{ old('destination', $order->destination) }}"
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
                                <textarea
                                          id="routeInput"
                                          name="route"
                                          class="form-control @error('route') is-invalid @enderror"
                                          placeholder="Masukkan rute perjalanan"
                                          rows="3">{{ old('route', $order->route) }}</textarea>
                                @error('route')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Jumlah Armada -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="vehicleCountInput" class="form-label">Jumlah Armada</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="number"
                                       id="vehicleCountInput"
                                       name="vehicle_count"
                                       class="form-control @error('vehicle_count') is-invalid @enderror"
                                       placeholder="Masukkan jumlah armada"
                                       value="{{ old('vehicle_count', $order->vehicle_count) }}"
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
                                                {{ collect(old('vehicle_ids', $order->vehicles->pluck('id')->toArray()))->contains($vehicle->id) ? 'selected' : '' }}>
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

                        <!-- Driver Pilihan -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="driverIdsInput" class="form-label">Driver Pilihan</label>
                            </div>
                            <div class="col-lg-9">
                                <select
                                        id="driverIdsInput"
                                        name="driver_ids[]"
                                        class="form-select @error('driver_ids') is-invalid @enderror"
                                        data-choices data-choices-removeItem multiple
                                        required>
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->id }}"
                                                {{ (is_array(old('driver_ids')) && in_array($driver->id, old('driver_ids'))) || (!is_array(old('driver_ids')) && $order->drivers->contains($driver->id)) ? 'selected' : '' }}>
                                            {{ $driver->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('driver_ids')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Pilih satu atau lebih driver</small>
                            </div>
                        </div>

                        <!-- Harga Sewa -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="rentalPriceInput" class="form-label">Harga Sewa</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="number"
                                       id="rentalPriceInput"
                                       name="rental_price"
                                       class="form-control @error('rental_price') is-invalid @enderror"
                                       placeholder="Rp - Masukkan harga sewa"
                                       value="{{ old('rental_price', $order->rental_price) }}"
                                       min="0"
                                       required>
                                @error('rental_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- DP -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="downPaymentInput" class="form-label">Uang Muka</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="number"
                                       id="downPaymentInput"
                                       name="down_payment"
                                       class="form-control @error('down_payment') is-invalid @enderror"
                                       placeholder="Rp - Masukkan jumlah DP"
                                       value="{{ old('down_payment', $order->down_payment) }}"
                                       min="0"
                                       required>
                                @error('down_payment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Sisa Bayar -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="remainingCostInput" class="form-label">Sisa Bayar</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="number"
                                       id="remainingCostInput"
                                       name="remaining_cost"
                                       class="form-control @error('remaining_cost') is-invalid @enderror"
                                       placeholder="Rp - Sisa bayar akan dihitung otomatis"
                                       value="{{ old('remaining_cost', $order->remaining_cost) }}"
                                       readonly>
                                @error('remaining_cost')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="statusInput" class="form-label">Status Pemesanan</label>
                            </div>
                            <div class="col-lg-9">
                                <select
                                        id="statusInput"
                                        name="status"
                                        class="form-select @error('status') is-invalid @enderror"
                                        data-choices
                                        required>
                                    <option value="" disabled>Pilih status</option>
                                    <option value="waiting" {{ old('status', $order->status) == 'waiting' ? 'selected' : '' }}>Waiting</option>
                                    <option value="approved" {{ old('status', $order->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="canceled" {{ old('status', $order->status) == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Catatan Tambahan -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="additionalNotesInput" class="form-label">Catatan Tambahan</label>
                            </div>
                            <div class="col-lg-9">
                                <textarea
                                          id="additionalNotesInput"
                                          name="additional_notes"
                                          class="form-control @error('additional_notes') is-invalid @enderror"
                                          placeholder="Masukkan catatan tambahan (opsional)"
                                          rows="3">{{ old('additional_notes', $order->additional_notes) }}</textarea>
                                @error('additional_notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="text-end">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
            // Choices.js is initialized automatically via data-choices attributes

            // Calculate remaining cost when rental price or down payment changes
            const rentalPriceInput = document.getElementById('rentalPriceInput');
            const downPaymentInput = document.getElementById('downPaymentInput');
            const remainingCostInput = document.getElementById('remainingCostInput');

            function calculateRemainingCost() {
                const rentalPrice = parseInt(rentalPriceInput.value) || 0;
                const downPayment = parseInt(downPaymentInput.value) || 0;
                const remainingCost = rentalPrice - downPayment;

                remainingCostInput.value = remainingCost >= 0 ? remainingCost : 0;
            }

            rentalPriceInput.addEventListener('input', calculateRemainingCost);
            downPaymentInput.addEventListener('input', calculateRemainingCost);

            // Initial calculation
            calculateRemainingCost();

            // Add invoice button if status is approved
            const statusInput = document.getElementById('statusInput');
            const formActions = document.querySelector('.text-end');

            function updateInvoiceButton() {
                // Remove existing invoice button if any
                const existingInvoiceBtn = document.getElementById('invoiceBtn');
                if (existingInvoiceBtn) {
                    existingInvoiceBtn.remove();
                }

                // Add invoice button if status is approved
                if (statusInput.value === 'approved') {
                    const invoiceBtn = document.createElement('button');
                    invoiceBtn.id = 'invoiceBtn';
                    invoiceBtn.type = 'button';
                    invoiceBtn.className = 'btn btn-success ms-2';
                    invoiceBtn.textContent = 'Invoice';

                    invoiceBtn.onclick = function cetakInvoiceButton() {
                        const id = "{{ $order->id }}";                        
                        $.get("{!! route('admin.orders.cetak-form') !!}", {
                            id: id
                        }).done(function(data) {
                            if (data.status == 'success') {
                                var w = window.open();
                                $(w.document.body).html(data.html);
                                setTimeout(function () {
                                    w.focus();
                                    w.print();
                                    w.close();
                                }, 500);
                            } else {
                                $('.main-page').show();
                            }
                        });
                    };

                    formActions.insertBefore(invoiceBtn, formActions.lastElementChild);
                }

            }

            statusInput.addEventListener('change', updateInvoiceButton);

            // Initial check for invoice button
            updateInvoiceButton();
        });
    </script>
@endpush
