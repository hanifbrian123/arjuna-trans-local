@extends('layouts.master')

@section('title', 'Manajemen Armada')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Armada</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Armada</li>
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
                                Daftar Armada
                            </h5>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary">
                                <i class="ri-add-line align-bottom"></i> Tambah Baru
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Card Header -->

                <!-- Card Body -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="vehiclesTable" class="table table-bordered table-nowrap align-middle" style="width:100%">
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
                                @foreach($vehicles as $index => $vehicle)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $vehicle->name }}</td>
                                    <td>{{ $vehicle->type }}</td>
                                    <td>{{ $vehicle->capacity }}</td>
                                    <td>
                                        @if(!empty($vehicle->facilities))
                                            @foreach($vehicle->facilities as $facility)
                                                <span class="badge bg-info me-1">{{ $facility }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($vehicle->status == 'ready')
                                            <span class="badge bg-success">Siap</span>
                                        @elseif($vehicle->status == 'maintenance')
                                            <span class="badge bg-warning">Maintenance</span>
                                        @elseif($vehicle->status == 'booked')
                                            <span class="badge bg-danger">Terpesan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.vehicles.show', $vehicle->id) }}" class="btn btn-sm btn-info">
                                                <i class="ri-eye-fill"></i>
                                            </a>
                                            <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="btn btn-sm btn-success">
                                                <i class="ri-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" class="delete-form d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="ri-delete-bin-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Card Body -->
            </div>
        </div>
    </div>
@endsection

@push('styles')
<link href="{{ asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/libs/datatables/datatables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#vehiclesTable').DataTable({
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

        // Event delegation untuk form delete
        $(document).on('submit', '.delete-form', function(e) {
            e.preventDefault();
            const form = this;

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data armada akan dihapus permanen!',
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
