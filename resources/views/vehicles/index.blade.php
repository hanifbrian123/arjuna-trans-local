@extends('layouts.master')

@section('title', 'Manajemen Armada')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <!-- Card Header -->
                <div class="card-header border-bottom-dashed">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                        <div>
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                Daftar Armada
                            </h5>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
                                <i class="ri-add-line align-bottom"></i> Tambah Baru
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Card Header -->

                <div class="card-body">
                    <table id="vehiclesTable" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Seat</th>
                                <th>Fasilitas</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
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
    <!--jquery js-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#vehiclesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('vehicles.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'capacity',
                        name: 'capacity'
                    },
                    {
                        data: 'facilities',
                        name: 'facilities'
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
                    targets: [0, 6]
                }]
            });

            // Event delegation untuk form delete
            $(document).on('submit', '.delete-form', function(e) {
                e.preventDefault();
                const form = this;

                showConfirmDialog(
                    'Apakah Anda yakin?',
                    'Data armada akan dihapus permanen!',
                    'Ya, hapus!',
                    'Batal'
                ).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
