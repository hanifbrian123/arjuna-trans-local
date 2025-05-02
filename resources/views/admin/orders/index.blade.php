@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Daftar Order</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Daftar Order</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Daftar Order</h5>
                    <div class="mt-2">
                        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">
                            <i class="ri-add-line align-bottom me-1"></i> Tambah Order
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="statusFilter" class="form-label">Filter Status</label>
                                <select id="statusFilter" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="waiting">Menunggu</option>
                                    <option value="approved">Disetujui</option>
                                    <option value="canceled">Dibatalkan</option>
                                    <option value="completed">Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="dateFilter" class="form-label">Filter Tanggal</label>
                                <input type="date" id="dateFilter" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="armadaFilter" class="form-label">Filter Armada</label>
                                <select id="armadaFilter" class="form-select">
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
                                <select id="driverFilter" class="form-select">
                                    <option value="">Semua Driver</option>
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->id }}">{{ $driver->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3 d-flex justify-content-end">
                            <button id="resetFilters" class="btn btn-light">Reset Filter</button>
                        </div>
                    </div>

                    <table id="ordersTable" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Order</th>
                                <th>Tanggal Order</th>
                                <th>Nama Pemesan</th>
                                <th>Alamat Penjemputan</th>
                                <th>Tujuan Utama</th>
                                <th>Tanggal Pakai</th>
                                <th>Armada</th>
                                <th>Driver</th>
                                <th>Status</th>
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
@endsection

@push('styles')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
@endpush

@push('scripts')
    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#ordersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.orders.index') }}",
                    data: function(d) {
                        d.status = $('#statusFilter').val();
                        d.date = $('#dateFilter').val();
                        d.vehicle_type = $('#armadaFilter').val();
                        d.driver_id = $('#driverFilter').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id',
                        name: 'id',
                        render: function(data) {
                            return 'ORD-' + String(data).padStart(3, '0');
                        }
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
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'pickup_address',
                        name: 'pickup_address'
                    },
                    {
                        data: 'destination',
                        name: 'destination'
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
            $('#statusFilter, #dateFilter, #armadaFilter, #driverFilter').change(function() {
                table.draw();
            });

            // Reset filters
            $('#resetFilters').click(function() {
                $('#statusFilter').val('');
                $('#dateFilter').val('');
                $('#armadaFilter').val('');
                $('#driverFilter').val('');
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
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
