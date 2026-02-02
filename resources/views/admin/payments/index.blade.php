@extends('layouts.master')

@section('title', 'Laporan Payment')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Laporan Payment</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Laporan Payment</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <!-- Card Header -->
                <div class="card-header border-bottom-dashed p-2 p-sm-3">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                        <!-- Title Section -->
                        <h5 class="card-title mb-0">LAPORAN PEMBAYARAN</h5>

                        <!-- Filter Section - Right Aligned -->
                        <div class="ms-auto d-flex flex-column flex-sm-row gap-2 align-items-center">
                            <!-- Date Range -->
                            <div style="width: 180px;">
                                <input type="text" id="dateRangeFilter" class="form-control form-control-sm flatpickr-input" placeholder="Rentang Tanggal">
                            </div>

                            <!-- Payment Status -->
                            <div style="width: 140px;">
                                <select id="paymentStatusFilter" class="form-select form-select-sm">
                                    <option value="">Semua Status</option>
                                    <option value="paid">Lunas</option>
                                    <option value="unpaid">Belum Lunas</option>
                                </select>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2">
                                <button id="filterBtn" class="btn btn-sm btn-primary px-3">
                                    <i class="ri-filter-2-line"></i>
                                </button>
                                <button id="resetFilterBtn" class="btn btn-sm btn-light px-3">
                                    <i class="ri-refresh-line"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- End Card Header -->

                <!-- Summary Cards -->
                <div class="card-body border-bottom-dashed">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-animate bg-light">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="text-uppercase fw-medium text-muted mb-0">Total Pendapatan</p>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-primary-subtle rounded fs-3">
                                                <i class="ri-money-dollar-circle-line text-primary"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-animate bg-light">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="text-uppercase fw-medium text-muted mb-0">Total Uang Muka</p>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">Rp {{ number_format($totalDownPayment, 0, ',', '.') }}</h4>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                                <i class="ri-arrow-down-circle-line text-success"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-animate bg-light">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="text-uppercase fw-medium text-muted mb-0">Total Sisa Pembayaran</p>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="totalRemaining">Rp {{ number_format($totalRemaining, 0, ',', '.') }}</h4>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-warning-subtle rounded fs-3">
                                                <i class="ri-arrow-up-circle-line text-warning"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Summary Cards -->

                <!-- Table Section -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="paymentsTable" class="table nowrap align-middle minimizeTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No. Order</th>
                                    <th>Nama Pemesan</th>
                                    <th>Rute Tujuan</th>
                                    <th>Tanggal Pakai</th>
                                    <th>Total Harga</th>
                                    <th>Uang Muka (DP)</th>
                                    <th>Sisa Bayar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $index => $order)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @php
                                                $firstPart = substr($order->order_num, 0, 4);
                                                $rest = substr($order->order_num, 4);
                                            @endphp
                                            <div style="white-space: nowrap;">
                                                <strong>{{ $firstPart }}</strong><br>
                                                <span style="font-size: 9px !important;">{{ $rest }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $order->name }}<br>
                                            <small>
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->phone_number) }}" target="_blank">
                                                    {{ $order->phone_number }}
                                                </a>
                                            </small>
                                        </td>
                                        <td>
                                            {{ Str::limit(Str::after($order->destination, 'xxxx'), 50) }}
                                        </td>
                                        <td>{{ $order->start_date->format('d/m/Y') }} - {{ $order->end_date->format('d/m/Y') }}</td>
                                        <td>Rp {{ number_format($order->rental_price, 0, ',', '.') }}</td>
                                        <td>{{ $order->down_payment ? 'Rp ' . number_format($order->down_payment, 0, ',', '.') : 'Rp -' }}</td>
                                        <td>{{ $order->remaining_cost ? 'Rp ' . number_format($order->remaining_cost, 0, ',', '.') : 'Rp -' }}</td>
                                        <td>
                                            @if ($order->remaining_cost > 0)
                                                <span class="badge bg-warning">Belum Lunas</span>
                                            @else
                                                <span class="badge bg-success">Lunas</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                @if ($order->remaining_cost > 0)
                                                    <button type="button" class="btn btn-sm btn-primary btn-complete-payment"
                                                            data-id="{{ $order->id }}"
                                                            data-remaining="{{ $order->remaining_cost }}" title="Klik untuk pelunasan">
                                                        <i class="ri-checkbox-circle-line"></i> Pelunasan
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-light" disabled>
                                                        <i class="ri-checkbox-circle-line"></i> Lunas
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Table Section -->
            </div>
        </div><!--end col-->
    </div><!--end row-->
@endsection

@push('styles')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <!--flatpickr css-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <style>
        /* Custom adjustments for dark theme */
        .flatpickr-calendar {
            width: auto !important;
            font-family: inherit;
        }

        /* Mobile responsiveness */
        @media (max-width: 576px) {
            .card-header .d-flex {
                width: 100%;
            }

            #dateRangeFilter {
                width: 100% !important;
            }
        }

        /* Table responsiveness */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-nowrap th,
        .table-nowrap td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Ensure horizontal scrolling works well on mobile */
        @media (max-width: 767.98px) {
            .table-responsive {
                overflow-x: auto;
                max-width: 100%;
                margin-bottom: 1rem;
                -webkit-overflow-scrolling: touch;
            }

            .table-responsive::-webkit-scrollbar {
                height: 8px;
            }

            .table-responsive::-webkit-scrollbar-thumb {
                background-color: rgba(var(--vz-dark-rgb), 0.2);
                border-radius: 4px;
            }

            .table-responsive::-webkit-scrollbar-track {
                background-color: rgba(var(--vz-light-rgb), 0.1);
            }
        }
    </style>
@endpush

@push('scripts')
    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <!--flatpickr js-->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <!--sweetalert2 js-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#paymentsTable').DataTable({
                responsive: true
                scrollX: !0
            });

            // Initialize Flatpickr date range picker
            const urlParams = new URLSearchParams(window.location.search);
            let startDate = urlParams.get('start_date') || '';
            let endDate = urlParams.get('end_date') || '';
            let defaultDate = [];

            if (startDate && endDate) {
                defaultDate = [startDate, endDate];
            }

            // Initialize Flatpickr
            try {
                const flatpickrInstance = flatpickr("#dateRangeFilter", {
                    mode: "range",
                    dateFormat: "Y-m-d",
                    locale: "id",
                    defaultDate: defaultDate,
                    altInput: true,
                    altFormat: "j F Y",
                    showMonths: 1,
                    disableMobile: true,
                    theme: 'dark'
                });

                // Filter functionality
                $('#filterBtn').on('click', function() {
                    const dateRange = flatpickrInstance.selectedDates;
                    let startDate = '';
                    let endDate = '';

                    if (dateRange.length === 2) {
                        startDate = formatDate(dateRange[0]);
                        endDate = formatDate(dateRange[1]);
                    } else if (dateRange.length === 1) {
                        startDate = formatDate(dateRange[0]);
                        endDate = startDate;
                    }

                    const paymentStatus = $('#paymentStatusFilter').val();

                    // Redirect with filter parameters
                    window.location.href = "{{ route('admin.payments.index') }}" +
                        "?start_date=" + startDate +
                        "&end_date=" + endDate +
                        "&payment_status=" + paymentStatus;
                });
            } catch (e) {
                console.error("Error initializing Flatpickr:", e);

                // Fallback to simple date inputs if Flatpickr fails
                $('#filterBtn').on('click', function() {
                    const startDate = $('#dateRangeFilter').val();
                    const endDate = startDate;
                    const paymentStatus = $('#paymentStatusFilter').val();

                    window.location.href = "{{ route('admin.payments.index') }}" +
                        "?start_date=" + startDate +
                        "&end_date=" + endDate +
                        "&payment_status=" + paymentStatus;
                });
            }

            // Reset filter
            $('#resetFilterBtn').on('click', function() {
                window.location.href = "{{ route('admin.payments.index') }}";
            });

            // Set payment status filter value from URL parameters
            if (urlParams.has('payment_status')) {
                $('#paymentStatusFilter').val(urlParams.get('payment_status'));
            }

            // Helper function to format date as YYYY-MM-DD
            function formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            // Handle payment completion
            $(document).on('click', '.btn-complete-payment', function() {
            // $('.btn-complete-payment').on('click', function() {
                const orderId = $(this).data('id');
                const remainingAmount = $(this).data('remaining');
                const button = $(this);

                Swal.fire({
                    title: 'Konfirmasi Pelunasan',
                    text: `Apakah Anda yakin ingin melunasi pembayaran sebesar Rp ${new Intl.NumberFormat('id-ID').format(remainingAmount)}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Lunasi!',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return $.ajax({
                            url: "{{ route('admin.payments.complete') }}",
                            type: 'POST',
                            data: {
                                order_id: orderId,
                                _token: "{{ csrf_token() }}"
                            },
                            dataType: 'json'
                        }).then(response => {
                            return response;
                        }).catch(error => {
                            Swal.showValidationMessage(
                                `Request failed: ${error.responseJSON?.message || 'Terjadi kesalahan pada server'}`
                            );
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: result.value.message || 'Pembayaran berhasil dilunasi',
                            icon: 'success'
                        }).then(() => {
                            // Update the UI without refreshing
                            const row = button.closest('tr');
                            row.find('td:nth-child(9)').html('<span class="badge bg-success">Lunas</span>');

                            // Ganti tombol pelunasan dengan tombol disabled
                            const buttonContainer = button.parent();
                            buttonContainer.html(`
                                <button type="button" class="btn btn-sm btn-light" disabled>
                                    <i class="ri-checkbox-circle-line"></i> Lunas
                                </button>
                            `);

                            // Update the summary cards
                            // Ambil teks dari elemen totalRemaining
                            const totalRemainingText = $('#totalRemaining').text();
                            // Ekstrak angka dari format "Rp 1.234.567"
                            const currentRemainingTotal = parseInt(totalRemainingText.replace(/\D/g, ''));
                            // Kurangi dengan jumlah yang dibayarkan
                            const newRemainingTotal = currentRemainingTotal - remainingAmount;
                            // Format dan tampilkan nilai baru
                            $('#totalRemaining').text(`Rp ${new Intl.NumberFormat('id-ID').format(newRemainingTotal)}`);
                        });
                    }
                });
            });
        });
    </script>
@endpush
