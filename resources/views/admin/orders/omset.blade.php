@extends('layouts.master')

@section('title', 'Laporan Omset Armada')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Laporan Omset Armada</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Omset Armada</li>
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
                        <h5 class="card-title mb-0">OMSET ARMADA</h5>

                        <!-- Filter Section - Right Aligned -->
                        <div class="ms-auto d-flex flex-column flex-sm-row gap-2 align-items-center">
                            <!-- Date Range -->
                            <div style="width: 210px;">
                                <input type="text" id="dateRangeFilter" class="form-control form-control-sm flatpickr-input" placeholder="Rentang Tanggal">
                            </div>

                            <!-- Vehicle Filter -->
                            <div style="width: 260px;">
                                <select id="vehicleFilter" class="form-select form-select-sm">
                                    <option value="">Semua Armada</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" {{ (isset($vehicleId) && $vehicleId == $vehicle->id) ? 'selected' : (request('vehicle_id') == $vehicle->id ? 'selected' : '') }}>{{ $vehicle->name }} - {{ $vehicle->license_plate }}</option>
                                    @endforeach
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

                <!-- Summary Cards -->
                <div class="card-body border-bottom-dashed">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-animate bg-light">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="text-uppercase fw-medium text-muted mb-0">Total Omset (Cash In)</p>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">Rp {{ number_format($totalCashIn ?? 0, 0, ',', '.') }}</h4>
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
                                            <p class="text-uppercase fw-medium text-muted mb-0">Total Order</p>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ $totalOrder ?? 0 }}</h4>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                                <i class="ri-stack-line text-success"></i>
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
                                            <p class="text-uppercase fw-medium text-muted mb-0">Rata-rata Cash In per Order</p>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">Rp {{ number_format($avgCashIn ?? 0, 0, ',', '.') }}</h4>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-warning-subtle rounded fs-3 text-warning">
                                                &perp;
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
                        <table id="omsetTable" class="table nowrap align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Armada</th>
                                    <th>Cash In</th>
                                    <th>Tanggal</th>
                                    <th class="no-order-col">Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $index => $row)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            {{ $row->vehicle->name ?? '-' }}<br>
                                            <small class="text-primary">{{ $row->vehicle->license_plate ?? '-' }}</small>
                                        </td>
                                        <td>Rp {{ number_format($row->cash_in, 0, ',', '.') }}</td>
                                        <td>{{ $row->created_at->format('Y/m/d') }}</td>
                                        <td class="no-order-col">
                                            <div class="order-number-wrap">
                                                {{ $row->order_num }}<br>
                                                <small class="text-primary"><b>{{ $row->name }}</b> - {{ $row->destination ?? '-' }}</small>
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

        /* Preserve existing nowrap rules but allow specific columns to wrap */
        .table-nowrap th,
        .table-nowrap td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* No Order column: constrain width and allow wrapping */
        .no-order-col {
            /* override nowrap if present */
            white-space: normal !important;
            overflow-wrap: break-word;
            word-wrap: break-word;
            word-break: break-word;
            vertical-align: top;
        }

        @media (min-width: 768px) {
            .no-order-col {
                max-width: 320px;
            }
        }

        /* Mobile: make order column wider */
        @media (max-width: 767.98px) {
            .no-order-col {
                max-width: none;
                min-width: 250px;
            }

            #omsetTable {
                font-size: 0.875rem;
            }
        }

        .order-number-wrap {
            display: block;
            word-break: break-word;
            white-space: normal;
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
    <script>
        $(document).ready(function() {
            var table = $('#omsetTable').DataTable({
                responsive: false,
                scrollX: true,
            });

            // Initialize Flatpickr date range picker
            const urlParams = new URLSearchParams(window.location.search);
            let startDate = urlParams.get('start_date') || '';
            let endDate = urlParams.get('end_date') || '';
            let vehicleId = urlParams.get('vehicle_id') || '';
            let defaultDate = [];

            if (startDate && endDate) {
                defaultDate = [startDate, endDate];
            }

            // Ensure vehicle selection is applied even if Flatpickr fails
            if (vehicleId) {
                try { $('#vehicleFilter').val(vehicleId); } catch (e) {}
            }

            try {
                const fp = flatpickr("#dateRangeFilter", {
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

                // Apply vehicle selection from URL (if present)
                if (vehicleId) {
                    try { $('#vehicleFilter').val(vehicleId); } catch (e) {}
                }

                $('#filterBtn').on('click', function() {
                    const dateRange = fp.selectedDates;
                    let s = '';
                    let e = '';

                    if (dateRange.length === 2) {
                        s = formatDate(dateRange[0]);
                        e = formatDate(dateRange[1]);
                    } else if (dateRange.length === 1) {
                        s = formatDate(dateRange[0]);
                        e = s;
                    }

                    const selectedVehicle = $('#vehicleFilter').val() || '';
                    window.location.href = "{{ route('admin.orders.omset') }}" + "?start_date=" + s + "&end_date=" + e + "&vehicle_id=" + selectedVehicle;
                });
            } catch (e) {
                console.error(e);
                $('#filterBtn').on('click', function() {
                    const val = $('#dateRangeFilter').val();
                    const selectedVehicle = $('#vehicleFilter').val() || '';
                    window.location.href = "{{ route('admin.orders.omset') }}" + "?start_date=" + val + "&end_date=" + val + "&vehicle_id=" + selectedVehicle;
                });
            }

            $('#resetFilterBtn').on('click', function() {
                window.location.href = "{{ route('admin.orders.omset') }}";
            });

            function formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }
        });
    </script>
@endpush
