@extends('layouts.master')

@section('title', 'Kalender Order')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex gap-2">
                            <button id="prev" class="btn btn-sm btn-primary">
                                <i class="ri-arrow-left-s-line"></i>
                            </button>
                            <button id="today" class="btn btn-sm btn-primary">Today</button>
                            <h4 class="mb-0 ms-3">Mei 2025</h4>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <label for="armada-filter" class="me-2">Armada</label>
                                <select id="armada-filter" class="form-select form-select-sm" style="width: 150px; display: inline-block;">
                                    <option value="">Semua</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->type }}">{{ $vehicle->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="me-3">
                                <label for="driver-filter" class="me-2">Driver</label>
                                <select id="driver-filter" class="form-select form-select-sm" style="width: 150px; display: inline-block;">
                                    <option value="">Semua</option>
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->id }}">{{ $driver->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button id="monthly-view" class="btn btn-primary">Monthly</button>
                        </div>
                    </div>

                    <div class="d-flex mb-3 flex-wrap">
                        @php
                            $colors = ['bg-primary', 'bg-danger', 'bg-purple', 'bg-success', 'bg-warning'];
                            $colorIndex = 0;
                        @endphp

                        @foreach ($vehicles->where('status', 'ready')->take(5) as $vehicle)
                            <div class="legend-item me-3 mb-2">
                                <span class="legend-dot {{ $colors[$colorIndex % count($colors)] }} rounded-circle d-inline-block me-1" style="width: 10px; height: 10px;"></span>
                                <span>{{ $vehicle->name }}</span>
                            </div>
                            @php $colorIndex++; @endphp
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div id="calendar"></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('orders.create') }}" class="btn btn-primary">New schedule</a>
                    </div>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->

    <!-- Order Detail Modal -->
    <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailModalLabel">Detail Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 id="modal-title" class="mb-3"></h5>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Tanggal:</strong> <span id="modal-date"></span></p>
                                <p class="mb-1"><strong>Tempat:</strong> <span id="modal-destination"></span></p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Driver:</strong> <span id="modal-driver-name"></span></p>
                                <p class="mb-1"><strong>Jemput:</strong> <span id="modal-pickup"></span></p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Tujuan:</strong> <span id="modal-destination-detail"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="#" id="modal-view-link" class="btn btn-primary">Reschedule</a>
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
            border-radius: 0 !important;
            padding: 2px 4px !important;
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

            // Sample vehicle colors
            const vehicleColors = {
                @php
                    $colors = ['#3788d8', '#dc3545', '#9b59b6', '#2ecc71', '#e67e22'];
                    $colorIndex = 0;
                @endphp

                @foreach ($vehicles->where('status', 'ready')->take(5) as $vehicle)
                    '{{ $vehicle->name }}': '{{ $colors[$colorIndex % count($colors)] }}', // {{ ['primary', 'danger', 'purple', 'success', 'warning'][$colorIndex % 5] }}
                    @php $colorIndex++; @endphp
                @endforeach
            };

            // Function to get events with filters
            function getEvents() {
                const driverId = driverFilter.value;
                const vehicleType = armadaFilter.value;

                // Build URL with filters
                let url = "{{ route('orders.calendar') }}";
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
                events: [
                    // Sample events using actual vehicle names
                    @php
                        $vehicleList = $vehicles->where('status', 'ready')->take(5)->values();
                        $driverNames = ['Wawan Hendrawan', 'Dedi Kurniawan', 'Agus Setiawan', 'Budi Santoso', 'Joko Widodo'];
                        $destinations = ['Bitung', 'Bandung', 'Jakarta', 'Bogor', 'Surabaya'];
                        $pickups = ['SD Negeri Kota Kuning 2 - Jl. Brigjend Katamso, Kec. Kiaracondong', 'Terminal Leuwi Panjang', 'Jl. Merdeka No. 10', 'Stasiun Bandung', 'Mall Paris Van Java'];
                        $customerNames = ['Siswanto Widodo', 'Joko Susanto', 'Anang Hermanto', 'Wahyu Prasetyo', 'Bambang Pamungkas'];
                    @endphp

                    @foreach ($vehicleList as $index => $vehicle)
                        {
                            id: {{ $index + 1 }},
                            title: '{{ $vehicle->name }} - {{ $destinations[$index % count($destinations)] }} - {{ $vehicle->capacity }} Seats',
                            start: '2025-05-{{ 6 + $index * 5 }}T{{ 8 + $index * 2 }}:00:00',
                            end: '2025-05-{{ 6 + $index * 5 }}T{{ 10 + $index * 2 }}:00:00',
                            color: '{{ $colors[$index % count($colors)] }}',
                            extendedProps: {
                                destination: '{{ $destinations[$index % count($destinations)] }}',
                                vehicle_type: '{{ $vehicle->type }}',
                                driver_name: '{{ $driverNames[$index % count($driverNames)] }}',
                                pickup: '{{ $pickups[$index % count($pickups)] }}',
                                seats: '{{ $vehicle->capacity }} Seats'
                            }
                        }
                        {{ $index < count($vehicleList) - 1 ? ',' : '' }}
                    @endforeach
                ],
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();

                    // Format dates
                    const startDate = new Date(info.event.start);
                    const formattedDate = startDate.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    });

                    const formattedTime = startDate.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    });

                    // Set modal content
                    document.getElementById('modal-title').textContent = info.event.title;
                    document.getElementById('modal-date').textContent = formattedDate + ' ' + formattedTime;
                    document.getElementById('modal-destination').textContent = info.event.extendedProps.destination;
                    document.getElementById('modal-destination-detail').textContent = info.event.extendedProps.destination;
                    document.getElementById('modal-driver-name').textContent = info.event.extendedProps.driver_name;
                    document.getElementById('modal-pickup').textContent = info.event.extendedProps.pickup;

                    // Set view link
                    document.getElementById('modal-view-link').href = "{{ route('orders.create') }}";

                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('orderDetailModal'));
                    modal.show();
                }
            });

            calendar.render();

            // Filter change handlers
            driverFilter.addEventListener('change', function() {
                // In a real implementation, this would filter the events
                // For the demo, we'll just keep the sample events
            });

            armadaFilter.addEventListener('change', function() {
                // In a real implementation, this would filter the events
                // For the demo, we'll just keep the sample events
            });

            // Button handlers
            document.getElementById('today').addEventListener('click', function() {
                calendar.today();
            });

            document.getElementById('prev').addEventListener('click', function() {
                calendar.prev();
            });

            document.getElementById('monthly-view').addEventListener('click', function() {
                calendar.changeView('dayGridMonth');
            });
        });
    </script>
@endpush
