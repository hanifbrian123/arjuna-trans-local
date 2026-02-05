@extends('layouts.master')
@section('title', 'Pengeluaran')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Manajemen Pengeluaran</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Manajemen Pengeluaran</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div>
                    <h5 class="card-title mb-0">Manajemen Pengeluaran</h5>
                </div>
                <div class="mt-2">
                    <a href="{{ route('admin.expenses.create') }}" class="btn btn-primary  mb-1 mb-md-0" title="Klik Untuk Menambah Data">
                        <i class="ri-add-line align-bottom me-1"></i> Tambah Pengeluaran
                    </a>
                    <a href="{{ route('admin.expense_categories.index') }}" class="btn btn-outline-secondary" title="Klik Untuk Kelola Kategori">
                        <i class="mdi mdi-cog-outline align-bottom me-1"></i> Kelola Kategori
                    </a>
                </div>
            </div>

            <div class="card-body">
                <!-- Filter Section -->
                <div class="row mb-1">
                    <!-- Armada Filter -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="armadaFilter" class="form-label">Armada</label>
                            <select id="armadaFilter" class="form-select">
                                <option value="">Semua Armada</option>
                                @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Expense Category Filter -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="categoryFilter" class="form-label">Kategori</label>
                            <select id="categoryFilter" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach ($expense_categories as $expense_category)
                                    <option value="{{ $expense_category->code }}">{{ $expense_category->code.' - '.$expense_category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Date Range Filter -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dateRangeFilter" class="form-label">Tanggal</label>
                            <input type="text" id="dateRangeFilter" class="form-control flatpickr-input" placeholder="Rentang Tanggal">
                        </div>
                    </div>
                </div>
                

                <!-- Summary Cards -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-animate bg-light">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="text-uppercase fw-medium text-muted mb-0">Total Pengeluaran</p>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="totalExpense"></h4>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-danger-subtle rounded fs-3 text-danger">
                                                &#x2197;
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
                                            <p class="text-uppercase fw-medium text-muted mb-0">Unit Armada Terdata</p>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="totalVehicles"></h4>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle rounded fs-3 text-success">
                                                &cong;
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
                                            <p class="text-uppercase fw-medium text-muted mb-0">Rata-rata Per Unit</p>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-0"id="avgExpense"></h4>
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

                <!-- Chart Section -->
                <div class="row mt-1">
                    <div class="col-md-6 mb-1">
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-1 fs-6 text-secondary">Proporsi Biaya (Sub-Kategori)</p>
                                <canvas id="categoryChart" style="height: 300px; max-height: 300px;"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-1 fs-6 text-secondary">Biaya Per Armada</p>
                                <canvas id="vehicleChart" style="height: 300px; max-height: 300px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Expense Table -->
                <table id="expenseTable" class="table nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Unit</th>
                            <th>Nominal</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
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

        /* Allow text wrapping for specific columns */
        #expenseTable thead th:nth-child(2),
        #expenseTable tbody td:nth-child(2),
        #expenseTable thead th:nth-child(6),
        #expenseTable tbody td:nth-child(6) {
            white-space: normal !important;
            overflow-wrap: break-word;
            word-wrap: break-word;
            word-break: break-word;
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


        #expenseTable td {
            padding: 16px 12px;
            vertical-align: middle;
        }
        #expenseTable tbody tr {
            border-bottom: 1px solid #eee;
        }
        #expenseTable tbody tr:hover {
            background-color: #f8f9fa;
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
    <!--Chart js-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            function formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

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
            var table = $('#expenseTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                scrollX: false,
                // order: [[4, 'asc']],

                ajax: {
                    url: "{{ route('admin.expenses.index') }}",
                    data: function(d) {

                        // Filter Armada
                        d.vehicle_id = $('#armadaFilter').val();

                        // Filter Kategori
                        d.category_code = $('#categoryFilter').val();

                        // Filter tanggal
                        const dateRange = flatpickrInstance.selectedDates;
                        if (dateRange.length === 2) {
                            d.start_date = formatDate(dateRange[0]);
                            d.end_date = formatDate(dateRange[1]);
                        } else if (dateRange.length  === 1) {
                            d.start_date = formatDate(dateRange[0]);
                            d.end_date = formatDate(dateRange[0]);
                        }
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'vehicle', name: 'vehicles.name', orderable: false},
                    {data: 'nominal', name: 'nominal'},
                    {data: 'category', name: 'expense_categories.code'},
                    {data: 'date', name: 'date'},
                    {data: 'description', name: 'description'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // Event filter
            $('#armadaFilter, #categoryFilter').change(function() {
                table.draw();
            });

            flatpickrInstance.config.onChange.push(function() {
                table.draw();
            });

            // Event delegation untuk form delete
            $(document).on('submit', '.delete-form', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Hapus Data?',
                    text: 'Data pengeluaran tidak dapat dipulihkan!',
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



            // CHART
            const categoryCtx = document.getElementById('categoryChart');
            const vehicleCtx = document.getElementById('vehicleChart');

            let categoryChart;
            let vehicleChart;

            

            function loadCharts() {
                // Filter Tanggal dari Flatpickr
                const dateRangeChart = flatpickrInstance.selectedDates;
                
                let start_date;
                let end_date;

                if (dateRangeChart.length === 2) {
                    start_date = formatDate(dateRangeChart[0]);
                    end_date = formatDate(dateRangeChart[1]);
                } else if (dateRangeChart.length  === 1) {
                    start_date = dateRangeChart[0].toISOString().split('T')[0];
                    end_date = start_date;
                }
                
                $.ajax({
                    url: "{{ route('admin.expenses.filter') }}",
                    data: {
                        vehicle_id: $('#armadaFilter').val(),
                        category_code: $('#categoryFilter').val(),
                        start_date: start_date,
                        end_date: end_date
                    },
                    success: function(response) {
                        
                        // Update Ringkasan
                        $('#totalExpense').text("Rp " + response.summary.total.toLocaleString('id-ID'));
                        $('#totalVehicles').text(response.summary.totalVehicles + " Unit");
                        $('#avgExpense').text("Rp " + Math.round(response.summary.avgPerVehicle).toLocaleString('id-ID'));

                        // Destroy existing charts
                        if (categoryChart) categoryChart.destroy();
                        if (vehicleChart) vehicleChart.destroy();

                        // CATEGORY DONUT CHART
                        categoryChart = new Chart(categoryCtx, {
                            type: 'doughnut',
                            data: {
                                labels: response.categories.map(c => c.name),
                                datasets: [{
                                    data: response.categories.map(c => c.total),
                                    backgroundColor: response.categories.map(c => c.color),
                                    hoverOffset: 17
                                }]
                            },
                            options: {
                                responsive: true,
                                cutout: '0%',
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            boxWidth: 10,
                                            padding: 10,
                                            usePointStyle: true,
                                            font: { size: 8 }
                                        },
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                const value = context.raw || 0;
                                                return " Rp " + value.toLocaleString('id-ID');
                                            }
                                        }
                                    }
                                },
                                layout: {
                                    padding: 30
                                }
                            }
                            
                        });

                        // VEHICLE BAR CHART
                        vehicleChart = new Chart(vehicleCtx, {
                            type: 'bar',
                            data: {
                                labels: response.vehicles.map(v => v.name),
                                datasets: [{
                                    label: "Biaya",
                                    data: response.vehicles.map(v => v.total),
                                    backgroundColor: '#6366f1',
                                    maxBarThickness: 40
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: val => "Rp " + val.toLocaleString('id-ID'),
                                            font: { size: 10 }
                                        },
                                        grid: {
                                            color: "#f3f4f6"
                                        }
                                    },
                                    x: {
                                        ticks: { font: { size: 10 } },
                                        grid: { display: false }
                                    }
                                },
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return "Rp " + context.raw.toLocaleString('id-ID');
                                            }
                                        }
                                    }
                                },
                                layout: {
                                    padding: 10
                                }
                            }
                        });
                    },
                });
            }



            // Event filter
            $('#armadaFilter, #categoryFilter').change(function() {
                loadCharts();
            });

            flatpickrInstance.config.onChange.push(function() {
                loadCharts();
            });

            // First load
            loadCharts();

        });
    </script>
@endpush
