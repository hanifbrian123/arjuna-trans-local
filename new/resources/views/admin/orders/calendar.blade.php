@extends('layouts.master')

@section('title', 'Kalender Order')
<style>
    .fc-event {
        cursor: pointer;
    }
</style>


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Calender Orders</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Calender Orders</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                
                <div class="card-header">
                    <h5 class="card-title mb-0">Calender Orders</h5>
                    <div class="mt-2">                        
                    </div>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex gap-2 align-items-center">
                            <button id="prev" class="btn btn-sm btn-primary">
                                <i class="ri-arrow-left-s-line"></i>
                            </button>
                            <button id="today" class="btn btn-sm btn-primary">Hari Ini</button>
                            <button id="next" class="btn btn-sm btn-primary">
                                <i class="ri-arrow-right-s-line"></i>
                            </button>
                            <h4 id="current-month" class="mb-0 ms-3"></h4>
                        </div>

                        <div class="d-flex align-items-center flex-wrap">
                            <div class="me-3 mb-2 mb-md-0">
                                <label for="armada-filter" class="me-2">Armada</label>
                                <select id="armada-filter" class="form-select form-select-sm" style="width: 150px; display: inline-block;">
                                    <option value="">Semua</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->type }}">{{ $vehicle->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="me-3 mb-2 mb-md-0">
                                <label for="driver-filter" class="me-2">Driver</label>
                                <select id="driver-filter" class="form-select form-select-sm" style="width: 150px; display: inline-block;">
                                    <option value="">Semua</option>
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->id }}">{{ $driver->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Only Monthly View Available -->
                            {{-- <div class="btn-group" role="group">
                                <button id="monthly-view" class="btn btn-primary btn-sm">Bulanan</button>
                            </div> --}}
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title mb-2">Keterangan Warna</h6>
                            <div class="d-flex flex-wrap">
                                <!-- Warna berdasarkan tipe kendaraan (dinamis dari database) -->
                                @php
                                    // Definisi warna untuk tipe kendaraan yang umum
                                    $vehicleColorMap = [
                                        'NKR 55 LWB' => '#4285F4',
                                        'HINO MDBL' => '#FBBC05',
                                        'HINO FB' => '#34A853',
                                        'Avanza' => '#34A853',
                                        'Innova' => '#FBBC05',
                                    ];

                                    // Warna default untuk tipe kendaraan lainnya
                                    $defaultColors = ['#3788d8', '#FF5722', '#00BCD4', '#795548', '#607D8B', '#E91E63', '#3F51B5', '#009688', '#8BC34A', '#FFC107'];
                                    $colorIndex = 0;
                                @endphp

                                @foreach ($vehicles->pluck('type')->unique() as $type)
                                    <div class="legend-item me-3 mb-2">
                                        @if (array_key_exists($type, $vehicleColorMap))
                                            <span class="legend-dot" style="background-color: {{ $vehicleColorMap[$type] }}; width: 10px; height: 10px;"></span>
                                        @else
                                            <span class="legend-dot" style="background-color: {{ $defaultColors[$colorIndex % count($defaultColors)] }}; width: 10px; height: 10px;"></span>
                                            @php $colorIndex++; @endphp
                                        @endif
                                        <span>{{ $type }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Detail Modal -->
    <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="orderDetailModalLabel">Detail Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Informasi Utama -->
                            <div class="card border shadow-none mb-3">
                                <div class="card-header bg-soft-primary">
                                    <h6 class="card-title mb-0">Informasi Utama</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-5">
                                            <p class="mb-0 text-muted">Nomor Order:</p>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="mb-0 fw-medium" id="modal-order-num">-</p>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-5">
                                            <p class="mb-0 text-muted">Status:</p>
                                        </div>
                                        <div class="col-md-7">
                                            <span class="badge bg-success" id="modal-status">-</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-5">
                                            <p class="mb-0 text-muted">Pelanggan:</p>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="mb-0 fw-medium" id="modal-customer">-</p>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-5">
                                            <p class="mb-0 text-muted">Telepon:</p>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="mb-0 fw-medium" id="modal-phone">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Kendaraan & Driver -->
                            <div class="card border shadow-none mb-3">
                                <div class="card-header bg-soft-success">
                                    <h6 class="card-title mb-0">Informasi Kendaraan & Driver</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-5">
                                            <p class="mb-0 text-muted">Tipe Armada:</p>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="mb-0 fw-medium" id="modal-vehicle">-</p>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-5">
                                            <p class="mb-0 text-muted">Jumlah Unit:</p>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="mb-0 fw-medium" id="modal-vehicle-count">-</p>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-5">
                                            <p class="mb-0 text-muted">Driver:</p>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="mb-0 fw-medium" id="modal-driver">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Informasi Perjalanan -->
                            <div class="card border shadow-none mb-3">
                                <div class="card-header bg-soft-info">
                                    <h6 class="card-title mb-0">Informasi Perjalanan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-5">
                                            <p class="mb-0 text-muted">Tanggal Mulai:</p>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="mb-0 fw-medium" id="modal-start-date">-</p>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-5">
                                            <p class="mb-0 text-muted">Tanggal Selesai:</p>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="mb-0 fw-medium" id="modal-end-date">-</p>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-5">
                                            <p class="mb-0 text-muted">Alamat Jemput:</p>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="mb-0 fw-medium" id="modal-pickup">-</p>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-5">
                                            <p class="mb-0 text-muted">Tujuan:</p>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="mb-0 fw-medium" id="modal-destination">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Pembayaran -->
                            <div class="card border shadow-none mb-3">
                                <div class="card-header bg-soft-warning">
                                    <h6 class="card-title mb-0">Informasi Pembayaran</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-5">
                                            <p class="mb-0 text-muted">Harga Sewa:</p>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="mb-0 fw-medium" id="modal-rental-price">-</p>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-5">
                                            <p class="mb-0 text-muted">Down Payment:</p>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="mb-0 fw-medium" id="modal-down-payment">-</p>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-5">
                                            <p class="mb-0 text-muted">Sisa Pembayaran:</p>
                                        </div>
                                        <div class="col-md-7">
                                            <p class="mb-0 fw-medium" id="modal-remaining-cost">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Tambahan -->
                    <div class="card border shadow-none">
                        <div class="card-header bg-soft-secondary">
                            <h6 class="card-title mb-0">Catatan Tambahan</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-0" id="modal-notes">-</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .fc-event {
            cursor: pointer;
        }

        .fc-toolbar-title {
            display: none;
        }

        .fc-daygrid-day-number,
        .fc-col-header-cell-cushion {
            color: #495057;
            text-decoration: none !important;
        }

        .fc-day-today {
            background-color: rgba(13, 110, 253, 0.1) !important;
        }

        .fc-event-time {
            display: none;
        }

        .fc-h-event {
            border: none !important;
        }

        .fc-daygrid-event-dot {
            display: none !important;
        }

        .bg-purple {
            background-color: #9b59b6 !important;
            color: #fff !important;
        }

        /* Time-based events styling */
        .fc-timegrid-event-harness {
            margin: 0 !important;
        }

        .fc-timegrid-event {
            border-radius: 0 !important;
        }

        /* Day grid events */
        .fc-daygrid-event {
            border-radius: 4px !important;
            padding: 3px 6px !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-left: 3px solid rgba(0, 0, 0, 0.2) !important;
            margin-bottom: 2px !important;
            font-size: 0.85em !important;
        }

        /* Add a subtle pattern to events for better distinction */
        .fc-daygrid-event::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.1) 50%, rgba(255, 255, 255, 0.1) 75%, transparent 75%, transparent);
            background-size: 10px 10px;
            border-radius: 4px;
            z-index: 0;
            opacity: 0.3;
        }

        /* Make sure the text is above the pattern */
        .fc-event-title {
            position: relative;
            z-index: 1;
        }

        /* Status-specific styling */
        .event-waiting {
            opacity: 0.9;
            border-style: dashed !important;
            border-width: 2px !important;
            background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent) !important;
            background-size: 10px 10px !important;
        }

        .event-approved {
            font-weight: bold;
        }

        .event-completed {
            opacity: 0.7;
        }

        .event-canceled {
            text-decoration: line-through;
            opacity: 0.6;
            background-image: repeating-linear-gradient(45deg, transparent, transparent 5px, rgba(255, 255, 255, 0.2) 5px, rgba(255, 255, 255, 0.2) 10px) !important;
        }

        /* Legend styling */
        .legend-dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-right: 15px;
            margin-bottom: 5px;
            font-size: 0.85rem;
        }

        /* Calendar header styling */
        .fc-col-header-cell {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        /* Day number styling */
        .fc-daygrid-day-number {
            font-weight: 600;
            padding: 8px !important;
        }

        /* Today button styling */
        #today {
            margin-right: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 10px;
            }

            .d-flex.gap-2 {
                flex-wrap: wrap;
            }

            #current-month {
                font-size: 1.2rem;
            }

            select.form-select-sm {
                width: 120px !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <!-- FullCalendar JS -->
    <script src="{{ asset('assets/libs/fullcalendar/index.global.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            let driverFilter = document.getElementById('driver-filter');
            let armadaFilter = document.getElementById('armada-filter');
            let currentMonthDisplay = document.getElementById('current-month');

            // CSRF token for AJAX requests
            let csrfToken = '';
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            if (csrfMeta) {
                csrfToken = csrfMeta.getAttribute('content');
            } else {
                console.warn('CSRF token meta tag not found');
            }

            // Function to get events with filters
            function getEvents() {
                const driverId = driverFilter.value;
                const vehicleType = armadaFilter.value;

                // Build URL with filters
                let url = "{{ route('admin.orders.calendar') }}";
                let params = [];

                if (driverId) {
                    params.push(`driver_id=${driverId}`);
                }

                if (vehicleType) {
                    params.push(`vehicle_type=${vehicleType}`);
                }

                if (params.length > 0) {
                    url += `?${params.join('&')}`;
                }

                return url;
            }

            // Initialize calendar
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: false,
                locale: 'id',
                events: function(info, successCallback, failureCallback) {
                    // Prepare headers
                    const headers = {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    };

                    // Add CSRF token if available
                    if (csrfToken) {
                        headers['X-CSRF-TOKEN'] = csrfToken;
                    }

                    // Add date range to request
                    const start = info.startStr;
                    const end = info.endStr;

                    // Build URL with all parameters
                    let url = getEvents();
                    // Check if URL already has parameters
                    url += (url.includes('?') ? '&' : '?') + `start=${start}&end=${end}`;

                    // Use fetch API to get events with proper headers
                    fetch(url, {
                            method: 'GET',
                            headers: headers,
                            credentials: 'same-origin'
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok: ' + response.status);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.error) {
                                throw new Error(data.error);
                            }
                            successCallback(data);
                        })
                        .catch(error => {
                            console.error('Error fetching events:', error);
                            // Show user-friendly error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to load calendar events. Please try again later.',
                                confirmButtonText: 'OK'
                            });
                            failureCallback(error);
                        });
                },
                eventClick: function(info) {
                    // Fetch detailed order data
                    const eventId = info.event.id;
                    const detailUrl = "{{ route('admin.orders.detail', ['order' => ':id']) }}".replace(':id', eventId);                    
                    fetch(detailUrl, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })

                    .then(response => response.json())
                    .then(data => {
                        // Populate modal with event data
                        document.getElementById('modal-order-num').textContent = data.order_num || '-';
                        document.getElementById('modal-customer').textContent = data.name || '-';

                        const phone = data.phone_number ? data.phone_number.replace(/^0/, '62') : null;
                        document.getElementById('modal-phone').innerHTML = phone
                        ? `<a href="https://wa.me/${phone}" target="_blank">+${phone}</a>`
                        : '-';

                        // document.getElementById('modal-phone').textContent = data.phone_number || '-';
                        document.getElementById('modal-destination').textContent = data.destination || '-';
                        document.getElementById('modal-vehicle').textContent = data.vehicle_type || '-';
                        document.getElementById('modal-vehicle-count').textContent = data.vehicle_count || '-';
                        document.getElementById('modal-driver').textContent = data.driver_name || '-';
                        document.getElementById('modal-pickup').textContent = data.pickup_address || '-';
                        document.getElementById('modal-notes').textContent = data.additional_notes || '-';

                        // Format dates
                        const startDate = data.start_date ? new Date(data.start_date) : null;
                        const endDate = data.end_date ? new Date(data.end_date) : null;

                        document.getElementById('modal-start-date').textContent = startDate ?
                            startDate.toLocaleString('id-ID', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            }) : '-';

                        document.getElementById('modal-end-date').textContent = endDate ?
                            endDate.toLocaleString('id-ID', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            }) : '-';

                        // Format currency
                        const formatter = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0
                        });

                        document.getElementById('modal-rental-price').textContent =
                            data.rental_price ? formatter.format(data.rental_price) : '-';
                        document.getElementById('modal-down-payment').textContent =
                            data.down_payment ? formatter.format(data.down_payment) : '-';
                        document.getElementById('modal-remaining-cost').textContent =
                            data.remaining_cost ? formatter.format(data.remaining_cost) : '-';

                        // Set status badge color
                        const statusElement = document.getElementById('modal-status');
                        statusElement.textContent = data.status || 'approved';

                        // Set status badge color
                        statusElement.className = 'badge';
                        switch (data.status) {
                            case 'waiting':
                                statusElement.classList.add('bg-warning');
                                statusElement.textContent = 'Menunggu';
                                break;
                            case 'approved':
                                statusElement.classList.add('bg-success');
                                statusElement.textContent = 'Disetujui';
                                break;
                            case 'canceled':
                                statusElement.classList.add('bg-danger');
                                statusElement.textContent = 'Dibatalkan';
                                break;
                            case 'completed':
                                statusElement.classList.add('bg-info');
                                statusElement.textContent = 'Selesai';
                                break;
                            default:
                                statusElement.classList.add('bg-secondary');
                        }

                        // Show modal
                        const modal = new bootstrap.Modal(document.getElementById('orderDetailModal'));
                        modal.show();
                    })
                    .catch(error => {
                            console.error('Error fetching order details:', error);
                            // Fallback to basic data if API fails
                            document.getElementById('modal-customer').textContent = info.event.extendedProps.name || '-';

                            const phone = data.phone_number ? data.phone_number.replace(/^0/, '62') : null;
                            document.getElementById('modal-phone').innerHTML = phone
                            ? `<a href="https://wa.me/${phone}" target="_blank">+${phone}</a>`
                            : '-';

                            // document.getElementById('modal-phone').textContent = info.event.extendedProps.phone_number || '-';
                            document.getElementById('modal-destination').textContent = info.event.extendedProps.destination || '-';
                            document.getElementById('modal-vehicle').textContent = info.event.extendedProps.vehicle_type || '-';
                            document.getElementById('modal-driver').textContent = info.event.extendedProps.driver_name || '-';
                            document.getElementById('modal-pickup').textContent = info.event.extendedProps.pickup || '-';

                            const statusElement = document.getElementById('modal-status');
                            statusElement.textContent = info.event.extendedProps.status || 'approved';

                            // Set status badge color
                            statusElement.className = 'badge';
                            switch (info.event.extendedProps.status) {
                                case 'waiting':
                                    statusElement.classList.add('bg-warning');
                                    statusElement.textContent = 'Menunggu';
                                    break;
                                case 'approved':
                                    statusElement.classList.add('bg-success');
                                    statusElement.textContent = 'Disetujui';
                                    break;
                                case 'canceled':
                                    statusElement.classList.add('bg-danger');
                                    statusElement.textContent = 'Dibatalkan';
                                    break;
                                case 'completed':
                                    statusElement.classList.add('bg-info');
                                    statusElement.textContent = 'Selesai';
                                    break;
                                default:
                                    statusElement.classList.add('bg-secondary');
                            }



                            // Show modal with limited data
                            const modal = new bootstrap.Modal(document.getElementById('orderDetailModal'));
                            modal.show();
                        });

                    // Prevent navigation to the event URL
                    info.jsEvent.preventDefault();
                },
                eventDidMount: function(info) {
                    // Add tooltip with more information
                    const tooltip = new bootstrap.Tooltip(info.el, {
                        title: `${info.event.extendedProps.driver_name || ''} - ${info.event.extendedProps.destination || ''}`,
                        placement: 'top',
                        trigger: 'hover',
                        container: 'body'
                    });
                },
                datesSet: function(info) {
                    // Update the month/year display
                    const date = info.view.currentStart;
                    const options = {
                        month: 'long',
                        year: 'numeric'
                    };
                    currentMonthDisplay.textContent = date.toLocaleDateString('id-ID', options);
                }
            });

            calendar.render();

            // Filter change handlers
            driverFilter.addEventListener('change', function() {
                try {
                    // Simply refetch events - the events function will use the updated filter values
                    calendar.refetchEvents();
                } catch (error) {
                    console.error('Error refreshing events after driver filter change:', error);
                }
            });

            armadaFilter.addEventListener('change', function() {
                try {
                    // Simply refetch events - the events function will use the updated filter values
                    calendar.refetchEvents();
                } catch (error) {
                    console.error('Error refreshing events after armada filter change:', error);
                }
            });

            // Button handlers
            document.getElementById('today').addEventListener('click', function() {
                calendar.today();
            });

            document.getElementById('prev').addEventListener('click', function() {
                calendar.prev();
            });

            document.getElementById('next').addEventListener('click', function() {
                calendar.next();
            });

            // Monthly view button just refreshes the current view
            document.getElementById('monthly-view').addEventListener('click', function() {
                try {
                    calendar.refetchEvents();
                } catch (error) {
                    console.error('Error refreshing events from monthly view button:', error);
                }
            });
        });
    </script>
@endpush
