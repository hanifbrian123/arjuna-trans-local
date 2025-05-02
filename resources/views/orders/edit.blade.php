@extends('layouts.master')

@section('title', 'Edit Order')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Order</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('orders.admin.index') }}">Order</a></li>
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
                    <h5 class="card-title mb-0">Form Edit Order</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.update', $order->id) }}" method="POST">
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

                        <!-- No. WhatsApp -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="phoneInput" class="form-label">No. WhatsApp</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text"
                                       id="phoneInput"
                                       name="phone_number"
                                       class="form-control @error('phone_number') is-invalid @enderror"
                                       placeholder="Masukkan nomor WhatsApp"
                                       value="{{ old('phone_number', $order->phone_number) }}"
                                       required>
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Alamat Pemesan -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="addressInput" class="form-label">Alamat Pemesan</label>
                            </div>
                            <div class="col-lg-9">
                                <textarea
                                          id="addressInput"
                                          name="address"
                                          class="form-control @error('address') is-invalid @enderror"
                                          placeholder="Masukkan alamat pemesan"
                                          rows="3"
                                          required>{{ old('address', $order->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tanggal Pakai -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="dateRangeInput" class="form-label">Tanggal Pakai</label>
                            </div>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <input type="datetime-local"
                                           id="startDateInput"
                                           name="start_date"
                                           class="form-control @error('start_date') is-invalid @enderror"
                                           value="{{ old('start_date', $order->start_date->format('Y-m-d\TH:i')) }}"
                                           required>
                                    <span class="input-group-text">-</span>
                                    <input type="datetime-local"
                                           id="endDateInput"
                                           name="end_date"
                                           class="form-control @error('end_date') is-invalid @enderror"
                                           value="{{ old('end_date', $order->end_date->format('Y-m-d\TH:i')) }}"
                                           required>
                                </div>
                                @error('start_date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                @error('end_date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
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

                        <!-- Tujuan Utama -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="destinationInput" class="form-label">Tujuan Utama</label>
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
                                          rows="3"
                                          required>{{ old('route', $order->route) }}</textarea>
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
                                       required>
                                @error('vehicle_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Armada -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="vehicleTypeSelect" class="form-label">Armada</label>
                            </div>
                            <div class="col-lg-9">
                                <select id="vehicleTypeSelect" name="vehicle_type" class="form-select @error('vehicle_type') is-invalid @enderror" data-choices required>
                                    <option value="">Pilih armada</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->type }}" {{ old('vehicle_type', $order->vehicle_type) == $vehicle->type ? 'selected' : '' }}>{{ $vehicle->type }} - {{ $vehicle->capacity }} Seat</option>
                                    @endforeach
                                </select>
                                @error('vehicle_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Driver Pilihan -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="driverNameSelect" class="form-label">Driver Pilihan</label>
                            </div>
                            <div class="col-lg-9">
                                <select id="driverNameSelect" name="driver_name" class="form-select @error('driver_name') is-invalid @enderror" data-choices required>
                                    <option value="">Pilih driver</option>
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->user->name }}" {{ old('driver_name', $order->driver_name) == $driver->user->name ? 'selected' : '' }}>{{ $driver->user->name }}</option>
                                    @endforeach
                                </select>
                                @error('driver_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Harga Sewa -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="rentalPriceInput" class="form-label">Harga Sewa</label>
                            </div>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number"
                                           id="rentalPriceInput"
                                           name="rental_price"
                                           class="form-control @error('rental_price') is-invalid @enderror"
                                           placeholder="Masukkan harga sewa"
                                           value="{{ old('rental_price', $order->rental_price) }}"
                                           min="0"
                                           required>
                                </div>
                                @error('rental_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Uang Muka -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="downPaymentInput" class="form-label">Uang Muka</label>
                            </div>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number"
                                           id="downPaymentInput"
                                           name="down_payment"
                                           class="form-control @error('down_payment') is-invalid @enderror"
                                           placeholder="Masukkan uang muka (opsional)"
                                           value="{{ old('down_payment', $order->down_payment) }}"
                                           min="0">
                                </div>
                                @error('down_payment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Sisa Ongkos -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="remainingCostInput" class="form-label">Sisa Ongkos</label>
                            </div>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number"
                                           id="remainingCostInput"
                                           name="remaining_cost"
                                           class="form-control @error('remaining_cost') is-invalid @enderror"
                                           placeholder="Sisa ongkos akan dihitung otomatis"
                                           value="{{ old('remaining_cost', $order->remaining_cost) }}"
                                           min="0"
                                           readonly>
                                </div>
                                <small class="text-muted">Sisa ongkos dihitung otomatis dari harga sewa dikurangi uang muka</small>
                                @error('remaining_cost')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status Pemesanan -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="statusSelect" class="form-label">Status Pemesanan</label>
                            </div>
                            <div class="col-lg-9">
                                <select id="statusSelect" name="status" class="form-select @error('status') is-invalid @enderror" data-choices required>
                                    <option value="">Pilih status</option>
                                    <option value="waiting" {{ old('status', $order->status) == 'waiting' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="approved" {{ old('status', $order->status) == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="canceled" {{ old('status', $order->status) == 'canceled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Lain-lain -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="additionalNotesInput" class="form-label">Lain-lain</label>
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
                            <a href="{{ route('orders.admin.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
            // Calculate remaining cost when rental price or down payment changes
            const rentalPriceInput = document.getElementById('rentalPriceInput');
            const downPaymentInput = document.getElementById('downPaymentInput');
            const remainingCostInput = document.getElementById('remainingCostInput');

            function calculateRemainingCost() {
                const rentalPrice = parseFloat(rentalPriceInput.value) || 0;
                const downPayment = parseFloat(downPaymentInput.value) || 0;
                const remainingCost = rentalPrice - downPayment;

                if (remainingCost >= 0) {
                    remainingCostInput.value = remainingCost;
                } else {
                    remainingCostInput.value = 0;
                    // Optional: Show an alert if down payment is greater than rental price
                    if (downPayment > rentalPrice) {
                        Swal.fire({
                            title: 'Peringatan',
                            text: 'Uang muka tidak boleh lebih besar dari harga sewa',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        downPaymentInput.value = rentalPrice;
                        remainingCostInput.value = 0;
                    }
                }
            }

            // Calculate on page load
            calculateRemainingCost();

            // Calculate when inputs change
            rentalPriceInput.addEventListener('input', calculateRemainingCost);
            downPaymentInput.addEventListener('input', calculateRemainingCost);
        });
    </script>
@endpush
