@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Data Orders</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Orders</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Data Orders</h5>
                    <div class="mt-2">
                        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary" title="Klik Untuk Menambah Data">
                            <i class="ri-add-line align-bottom me-1"></i> Buat Order
                        </a>

                        <button type="button" class="btn btn-info btn-view-trip" data-bs-toggle="modal" data-bs-target="#tripModal" title="Klik Untuk Melihat Data Trip Selesai">
                            <i class="ri-eye-line align-bottom me-1"></i> Trip Selesai
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="statusFilter" class="form-label">Filter Status</label>
                                <select id="statusFilter" class="form-select" data-choices>
                                    <option value="">Semua Status</option>
                                    <option value="waiting">Menunggu</option>
                                    <option value="approved">Disetujui</option>
                                    <option value="canceled">Dibatalkan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="dateRangeFilter" class="form-label">Tanggal</label>
                                <input type="text" id="dateRangeFilter" class="form-control flatpickr-input" placeholder="Rentang Tanggal">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="armadaFilter" class="form-label">Armada</label>
                                <select id="armadaFilter" class="form-select" data-choices>
                                    <option value="">Semua Armada</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->type }}">{{ $vehicle->type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="driverFilter" class="form-label">Filter Driver</label>
                                <select id="driverFilter" class="form-select" data-choices>
                                    <option value="">Semua Driver</option>
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->id }}">{{ $driver->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="ordersTable" class="table nowrap align-middle minimizeTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No. Order</th>
                                    <th>Tanggal Pakai</th>
                                    <th>Nama Pemesan</th>
                                    <th>Alamat Penjemputan</th>
                                    <th>Tujuan Utama</th>
                                    <th>Armada</th>
                                    <th>Driver</th>
                                    <th>Status</th>
                                    <th>Tanggal Order</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Trip Selesai -->
    <div class="modal fade" id="tripModal" tabindex="-1" aria-labelledby="tripModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tripModalLabel">Data Trip Selesai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <table id="tripFinishedTable" class="table nowrap align-middle minimizeTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Order</th>
                                <th>Tanggal Pakai</th>
                                <th>Nama Pemesan</th>
                                <th>Alamat Penjemputan</th>
                                <th>Tujuan Utama</th>
                                <th>Armada</th>
                                <th>Driver</th>
                                <th>Status</th>
                                <th>Tanggal Order</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

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
    <script>
        $(document).ready(function() {
            // Initialize Flatpickr date range picker
            const flatpickrInstance = flatpickr("#dateRangeFilter", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "id",
                altInput: true,
                altFormat: "j F Y",
                showMonths: 1,
                disableMobile: true,
                theme: 'dark'
            });

            // Helper function to format date
            function formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            // Initialize DataTable
            var table = $('#ordersTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                scrollX: false,
                ajax: {
                    url: "{{ route('admin.orders.index') }}",
                    data: function(d) {
                        d.status = $('#statusFilter').val();

                        // Get date range from flatpickr
                        const dateRange = flatpickrInstance.selectedDates;
                        if (dateRange.length === 2) {
                            d.start_date = formatDate(dateRange[0]);
                            d.end_date = formatDate(dateRange[1]);
                        } else if (dateRange.length === 1) {
                            d.start_date = formatDate(dateRange[0]);
                            d.end_date = formatDate(dateRange[0]);
                        }

                        d.vehicle_type = $('#armadaFilter').val();
                        d.driver_id = $('#driverFilter').val();
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'order_num',
                        name: 'order_num',
                        render: function(data, type, row) {
                            if (!data) return '';
                            const firstPart = data.substring(0, 4);
                            const rest = data.substring(4);

                            return `<div style="white-space: nowrap;">
                                        <strong>${firstPart}</strong><br>
                                        <span style="font-size: 9px !important;">${rest}</span>
                                    </div>`;
                        }
                    },
                    {
                        data: 'start_date',
                        name: 'start_date',
                        render: function(data, type, row) {
                            const startDate = new Date(data).toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric'
                            });
                            const startTime = new Date(data).toLocaleTimeString('id-ID', {
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                            const endDate = new Date(row.end_date).toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric'
                            });
                            const endTime = new Date(row.end_date).toLocaleTimeString('id-ID', {
                                hour: '2-digit',
                                minute: '2-digit'
                            });

                            return startDate + ', ' + startTime + '<br>' + endDate + ', ' + endTime;
                        }
                    },
                    {
                        data: 'nama_pemesan',
                        name: 'nama_pemesan'
                    },
                    {
                        data: 'pickup_address',
                        name: 'pickup_address',
                        render: function(data, type, row) {
                            if (type === 'display' && data.length > 20) {
                                return data.substr(0, 20) + ' .....';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'destination',
                        name: 'destination',
                        render: function(data, type, row) {
                            if (type === 'display' && data.length > 20) {
                                return data.substr(0, 20) + ' .....';
                            }
                            return data;
                        }
                    },                    
                    {
                        data: 'vehicle_type',
                        name: 'vehicle_type'
                    },
                    {
                        data: 'driver_name',
                        name: 'driver_name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data) {
                            return new Date(data).toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric'
                            });
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                columnDefs: [{
                    orderable: false,
                    targets: [0, 10]
                }],
                order: [
                    [2, 'desc']
                ] // Sort by created_at by default
            });

            // Apply filters when changed
            $('#statusFilter, #armadaFilter, #driverFilter').change(function() {
                table.draw();
            });

            // Apply date range filter when flatpickr changes
            flatpickrInstance.config.onChange.push(function() {
                table.draw();
            });

            // Event delegation untuk form delete
            $(document).on('submit', '.delete-form', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data order akan dihapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    didOpen: () => {
                        const confirmButton = Swal.getConfirmButton();
                        if (confirmButton) {
                            confirmButton.setAttribute('title', 'Klik untuk menghapus data secara permanen');
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Initialize DataTable for trip finished
            let tripTableInitialized = false;
            let tripTable;

            $('.btn-view-trip').on('click', function () {
                if (!tripTableInitialized) {
                    tripTable = $('#tripFinishedTable').DataTable({
                        processing: true,
                        serverSide: true,
                        // responsive: true,
                        scrollX: false,
                        ajax: {
                            url: '{{ route("admin.orders.trip-finished") }}',
                            type: 'GET'
                        },
                        columns: [
                        {
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'order_num',
                                name: 'order_num',
                            },
                            {
                                data: 'start_date',
                                name: 'start_date',
                                render: function(data, type, row) {
                                    const startDate = new Date(data).toLocaleDateString('id-ID', {
                                        day: '2-digit',
                                        month: 'short',
                                        year: 'numeric'
                                    });
                                    const startTime = new Date(data).toLocaleTimeString('id-ID', {
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    });
                                    const endDate = new Date(row.end_date).toLocaleDateString('id-ID', {
                                        day: '2-digit',
                                        month: 'short',
                                        year: 'numeric'
                                    });
                                    const endTime = new Date(row.end_date).toLocaleTimeString('id-ID', {
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    });

                                    return startDate + ', ' + startTime + '<br>' + endDate + ', ' + endTime;
                                }
                            },
                            {
                                data: 'nama_pemesan',
                                name: 'nama_pemesan'
                            },
                            {
                                data: 'pickup_address',
                                name: 'pickup_address',
                                render: function(data, type, row) {
                                    if (type === 'display' && data.length > 20) {
                                        return data.substr(0, 20) + ' .....';
                                    }
                                    return data;
                                }
                            },
                            {
                                data: 'destination',
                                name: 'destination',
                                render: function(data, type, row) {
                                    if (type === 'display' && data.length > 20) {
                                        return data.substr(0, 20) + ' .....';
                                    }
                                    return data;
                                }
                            },                    
                            {
                                data: 'vehicle_type',
                                name: 'vehicle_type'
                            },
                            {
                                data: 'driver_name',
                                name: 'driver_name'
                            },
                            {
                                data: 'status',
                                name: 'status'
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
                                render: function(data) {
                                    return new Date(data).toLocaleDateString('id-ID', {
                                        day: '2-digit',
                                        month: 'short',
                                        year: 'numeric'
                                    });
                                }
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ],
                        order: [[5, 'desc']]
                    });

                    tripTableInitialized = true;
                } else {
                    tripTable.ajax.reload();
                }
            });

            //change trip finished status
            $(document).on('submit', '.finished-form', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data order akan Diselesaikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, selesai!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    didOpen: () => {
                        const confirmButton = Swal.getConfirmButton();
                        if (confirmButton) {
                            confirmButton.setAttribute('title', 'Klik untuk menyelsaikan trip');
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

        });
    </script>
@endpush
