@extends('layouts.master')

@section('title', 'Kalender Order')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
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
                            <div class="btn-group" role="group">
                                <button id="monthly-view" class="btn btn-primary btn-sm">Bulanan</button>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title mb-2">Keterangan Warna</h6>
                            <div class="d-flex flex-wrap">
                                @php
                                    $colors = ['bg-primary', 'bg-danger', 'bg-purple', 'bg-success', 'bg-warning', 'bg-info', 'bg-secondary'];
                                    $colorIndex = 0;

                                    // Get unique vehicle types
                                    $vehicleTypes = $vehicles->pluck('type')->unique();
                                @endphp

                                @foreach ($vehicleTypes as $type)
                                    <div class="legend-item me-3 mb-2">
                                        <span class="legend-dot {{ $colors[$colorIndex % count($colors)] }} rounded-circle d-inline-block me-1" style="width: 10px; height: 10px;"></span>
                                        <span>{{ $type }}</span>
                                    </div>
                                    @php $colorIndex++; @endphp
                                @endforeach

                                <div class="ms-auto"></div>
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailModalLabel">Detail Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Tujuan:</p>
                            <p class="fw-medium" id="modal-destination">-</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Armada:</p>
                            <p class="fw-medium" id="modal-vehicle">-</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Driver:</p>
                            <p class="fw-medium" id="modal-driver">-</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Status:</p>
                            <span class="badge bg-success" id="modal-status">-</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <p class="mb-1 text-muted">Alamat Penjemputan:</p>
                            <p class="fw-medium" id="modal-pickup">-</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="#" id="modal-view-link" class="btn btn-primary">Lihat Detail</a>
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
                    // Populate modal with event data
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

                    // Set view link
                    document.getElementById('modal-view-link').href = info.event.url;

                    // Prevent navigation to the event URL
                    info.jsEvent.preventDefault();

                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('orderDetailModal'));
                    modal.show();
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
