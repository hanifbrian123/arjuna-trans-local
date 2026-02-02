@extends('layouts.master')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Laporan Keuangan</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Laporan Keuangan</li>
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
                    <h5 class="card-title mb-0">LAPORAN KEUANGAN</h5>

                    <!-- Filter Section - Right Aligned -->
                    <div class="ms-md-auto d-flex flex-column flex-sm-row gap-2 align-items-center">
                        <!-- Date Range -->
                        <div style="width: 260px;">
                            <input type="text" id="dateRangeFilter" class="form-control flatpickr-input" placeholder="Rentang Tanggal">
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button id="btnFilter" class="btn btn-sm btn-primary px-3">
                                <i class="ri-filter-2-line"></i>
                            </button>
                            <button id="btnReset" class="btn btn-sm btn-light px-3">
                                <i class="ri-refresh-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Card Header -->

            <!-- Summary Cards -->
            <div class="card-body mt-1 border-bottom-dashed">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-animate bg-light">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="text-uppercase fw-medium text-muted mb-0">Total Pendapatan</p>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="summaryIncome">Rp. 0</h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-success-subtle rounded fs-3 text-success">
                                            &#8601;
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
                                        <p class="text-uppercase fw-medium text-muted mb-0">Total Pengeluaran</p>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="summaryExpense">Rp. 0</h4>
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
                                        <p class="text-uppercase fw-medium text-muted mb-0">Kas (Laba/Rugi)</p>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-0"id="summaryProfit">Rp. 0</h4>
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

            <div class="d-flex m-2 gap-2">
                <!-- Export Excel -->
                <a href="{{ route('admin.finance.export.excel', request()->only(['start_date','end_date'])) }}"
                class="btn btn-success btn-sm d-flex align-items-center gap-2"
                title="Download laporan keuangan dalam format Excel">
                    <i class="ri-file-excel-2-line fs-5"></i>
                    <span>Export Excel</span>
                </a>

                <!-- Export PDF -->
                <a href="{{ route('admin.finance.export.pdf', request()->only(['start_date','end_date'])) }}"
                class="btn btn-danger btn-sm d-flex align-items-center gap-2"
                title="Download laporan keuangan dalam format PDF">
                    <i class="ri-file-pdf-2-line fs-5"></i>
                    <span>Export PDF</span>
                </a>
            </div>
            <!-- Table Section -->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="financeTable" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Kode</th>
                                <th>Keluar</th>
                                <th>Masuk</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Diisi dari datatable -->
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


            var table = $('#financeTable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                pageLength: 20,
                // order: [[1, 'desc']],
                ajax: {
                    url: "{{ route('admin.finance.transactions') }}",
                    data: function (d) {
                        // Filter tanggal
                        const dateRange = flatpickrInstance.selectedDates;
                        if (dateRange.length === 2) {
                            d.start_date = dateRange[0].toISOString().split('T')[0];
                            d.end_date = dateRange[1].toISOString().split('T')[0];
                        }
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'date', name: 'date', orderable: false },
                    { data: 'description', name: 'description', orderable: false },
                    { data: 'code', name: 'code', orderable: false },
                    { data: 'expense', name: 'expense', orderable: false },
                    { data: 'income', name: 'income', orderable: false },
                    { data: 'total', name: 'total', orderable: false },
                ]
            });



            function loadSummary() {
                console.log('tresttttt');
                
                const dateRange = flatpickrInstance.selectedDates;
                let start_date;
                let end_date;
                if (dateRange.length === 2) {
                    start_date = dateRange[0].toISOString().split('T')[0];
                    end_date = dateRange[1].toISOString().split('T')[0];
                }
                console.log(start_date, end_date);
                
                
                $.ajax({
                    url: "{{ route('admin.finance.summary') }}",
                    method: "GET",
                    data: {
                        start_date: start_date,
                        end_date: end_date
                    },
                    success: function (res) {

                        // Format rupiah helper
                        const rupiah = (value) => {
                            return "Rp " + Number(value).toLocaleString('id-ID');
                        };

                        $('#summaryIncome').text(rupiah(res.total_income));
                        $('#summaryExpense').text(rupiah(res.total_expense));

                        const profit = res.profit;

                        $('#summaryProfit')
                            .text(rupiah(profit))
                            .toggleClass("text-success", profit >= 0)
                            .toggleClass("text-danger", profit < 0);
                    },
                    error: function () {
                        console.log("Failed to load summary");
                    }
                });
            }

            $('#btnFilter').on('click', function () {
                table.ajax.reload();
                loadSummary();
            });

            $('#btnReset').on('click', function () {
                $('#dateRangeFilter').val('');
                flatpickrInstance.clear();
                table.ajax.reload();
                loadSummary();
            });

            table.ajax.reload();
            loadSummary();

            
        })
    </script>
{{-- <script>
    let chartFinance, chartSaldo;

    const ctxFinance = document.getElementById("chartFinance");
    const ctxSaldo = document.getElementById("chartSaldo");

    /* =====================================================
     *  FETCH DATA (CALL BACKEND)
     * ===================================================== */
    function loadFinanceReport() {
        const vehicle = $("#filterVehicle").val();
        const dateRange = $("#filterDateRange").val().split(" to ");
        const startDate = dateRange[0] || "";
        const endDate = dateRange[1] || "";

        $.ajax({
            url: "{{ route('admin.finance.data') }}",
            data: {
                vehicle_id: vehicle,
                start_date: startDate,
                end_date: endDate,
            },
            success: function (res) {

                // SUMMARY
                $("#sumPendapatan").text("Rp " + res.summary.pendapatan.toLocaleString("id-ID"));
                $("#sumPengeluaran").text("Rp " + res.summary.pengeluaran.toLocaleString("id-ID"));
                $("#sumLabaRugi").text("Rp " + res.summary.laba_rugi.toLocaleString("id-ID"));

                // CHART 1 (BAR + LINE)
                updateFinanceChart(res.monthly);

                // CHART 2 (SALDO)
                updateSaldoChart(res.arus_saldo);

                // TABLE
                updateFinanceTable(res.transaksi);
            }
        });
    }

    /* =====================================================
     *  FINANCE CHART
     * ===================================================== */
    function updateFinanceChart(data) {
        if (chartFinance) chartFinance.destroy();

        chartFinance = new Chart(ctxFinance, {
            type: "bar",
            data: {
                labels: data.map(x => x.bulan),
                datasets: [
                    {
                        label: "Pendapatan",
                        data: data.map(x => x.pendapatan),
                        backgroundColor: "rgba(59,130,246,0.8)",
                    },
                    {
                        label: "Pengeluaran",
                        data: data.map(x => x.pengeluaran),
                        backgroundColor: "rgba(239,68,68,0.8)",
                    },
                    {
                        type: "line",
                        label: "Profit",
                        data: data.map(x => x.profit),
                        borderColor: "rgba(34,197,94,1)",
                        borderWidth: 3,
                        fill: false,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: { mode: "index", intersect: false },
                plugins: { legend: { display: true } }
            }
        });
    }

    /* =====================================================
     *  SALDO CHART
     * ===================================================== */
    function updateSaldoChart(data) {
        if (chartSaldo) chartSaldo.destroy();

        chartSaldo = new Chart(ctxSaldo, {
            type: "line",
            data: {
                labels: data.map(x => x.bulan),
                datasets: [
                    {
                        label: "Saldo Akumulasi",
                        data: data.map(x => x.saldo),
                        borderColor: "rgba(139,92,246,1)",
                        backgroundColor: "rgba(139,92,246,0.2)",
                        borderWidth: 3,
                        fill: true,
                        tension: 0.2
                    }
                ]
            }
        });
    }

    /* =====================================================
     *  TABLE
     * ===================================================== */
    function updateFinanceTable(rows) {
        const tbody = $("#financeTableBody");
        tbody.empty();

        rows.forEach((r, i) => {
            tbody.append(`
                <tr>
                    <td>${i+1}</td>
                    <td>${r.date}</td>
                    <td>${r.keterangan}</td>
                    <td>${r.kode}</td>
                    <td>${r.keluar ? "Rp "+r.keluar.toLocaleString("id-ID") : "-"}</td>
                    <td>${r.masuk ? "Rp "+r.masuk.toLocaleString("id-ID") : "-"}</td>
                    <td>${"Rp "+r.total.toLocaleString("id-ID")}</td>
                </tr>
            `);
        });
    }

    /* INIT */
    loadFinanceReport();

    $("#btnFilter").click(loadFinanceReport);

    $("#btnReset").click(() => {
        $("#filterVehicle").val("");
        $("#filterDateRange").val("");
        loadFinanceReport();
    });
</script> --}}
@endpush
