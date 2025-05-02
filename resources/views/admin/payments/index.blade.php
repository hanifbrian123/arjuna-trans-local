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
                <div class="card-header border-bottom-dashed">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                        <div>
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                LAPORAN PEMBAYARAN
                            </h5>
                        </div>

                        <!-- Filter Section -->
                        <div class="d-flex gap-2">
                            <div class="input-group" style="max-width: 200px;">
                                <input type="date" id="startDateFilter" class="form-control form-control-sm" placeholder="Tanggal Mulai">
                            </div>
                            <div class="input-group" style="max-width: 200px;">
                                <input type="date" id="endDateFilter" class="form-control form-control-sm" placeholder="Tanggal Akhir">
                            </div>
                            <div class="input-group" style="max-width: 150px;">
                                <select id="statusFilter" class="form-select form-select-sm">
                                    <option value="">Semua Status</option>
                                    <option value="waiting">Menunggu</option>
                                    <option value="approved">Disetujui</option>
                                    <option value="completed">Selesai</option>
                                    <option value="canceled">Dibatalkan</option>
                                </select>
                            </div>
                            <button id="filterBtn" class="btn btn-sm btn-primary">Filter</button>
                            <button id="resetFilterBtn" class="btn btn-sm btn-light">Reset</button>
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
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">Rp {{ number_format($totalRemaining, 0, ',', '.') }}</h4>
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
                        <table id="paymentsTable" class="table table-bordered table-nowrap align-middle" style="width:100%">
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
                                        <td>ORD-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td>
                                            {{ $order->name }}<br>
                                            <small>{{ $order->phone_number }}</small>
                                        </td>
                                        <td>{{ $order->destination }}</td>
                                        <td>{{ $order->start_date->format('d/m/Y') }} - {{ $order->end_date->format('d/m/Y') }}</td>
                                        <td>Rp {{ number_format($order->rental_price, 0, ',', '.') }}</td>
                                        <td>{{ $order->down_payment ? 'Rp ' . number_format($order->down_payment, 0, ',', '.') : 'Rp -' }}</td>
                                        <td>{{ $order->remaining_cost ? 'Rp ' . number_format($order->remaining_cost, 0, ',', '.') : 'Rp -' }}</td>
                                        <td>
                                            @if ($order->status == 'waiting')
                                                <span class="badge bg-warning">Menunggu</span>
                                            @elseif($order->status == 'approved')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif($order->status == 'completed')
                                                <span class="badge bg-info">Selesai</span>
                                            @elseif($order->status == 'canceled')
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $order->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                                    <i class="ri-eye-fill"></i>
                                                </a>
                                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-success">
                                                    <i class="ri-pencil-fill"></i>
                                                </a>
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
@endpush

@push('scripts')
    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#paymentsTable').DataTable({
                responsive: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    zeroRecords: "Tidak ada data yang cocok",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });

            // Filter functionality
            $('#filterBtn').on('click', function() {
                const startDate = $('#startDateFilter').val();
                const endDate = $('#endDateFilter').val();
                const status = $('#statusFilter').val();

                // Redirect with filter parameters
                window.location.href = "{{ route('admin.payments.index') }}" +
                    "?start_date=" + startDate +
                    "&end_date=" + endDate +
                    "&status=" + status;
            });

            // Reset filter
            $('#resetFilterBtn').on('click', function() {
                window.location.href = "{{ route('admin.payments.index') }}";
            });

            // Set filter values from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('start_date')) {
                $('#startDateFilter').val(urlParams.get('start_date'));
            }
            if (urlParams.has('end_date')) {
                $('#endDateFilter').val(urlParams.get('end_date'));
            }
            if (urlParams.has('status')) {
                $('#statusFilter').val(urlParams.get('status'));
            }
        });
    </script>
@endpush
