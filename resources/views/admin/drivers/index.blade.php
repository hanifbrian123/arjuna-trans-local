@extends('layouts.master')

@section('title', 'Manajemen Driver')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Driver</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Driver</li>
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
                                Daftar Driver
                            </h5>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.drivers.create') }}" class="btn btn-primary">
                                <i class="ri-add-line align-bottom"></i> Tambah Baru
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Card Header -->

                <!-- Card Body -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="driversTable" class="table table-bordered table-nowrap align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Nomor Telepon</th>
                                    <th>Tipe SIM</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($drivers as $index => $driver)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $driver->user->name }}</td>
                                    <td>{{ $driver->user->email }}</td>
                                    <td>{{ $driver->phone_number }}</td>
                                    <td>SIM {{ $driver->license_type }}</td>
                                    <td>
                                        @if($driver->status == 'active')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.drivers.show', $driver->id) }}" class="btn btn-sm btn-info">
                                                <i class="ri-eye-fill"></i>
                                            </a>
                                            <a href="{{ route('admin.drivers.edit', $driver->id) }}" class="btn btn-sm btn-success">
                                                <i class="ri-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('admin.drivers.destroy', $driver->id) }}" method="POST" class="delete-form d-inline">
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
        $('#driversTable').DataTable({
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
                text: 'Data driver akan dihapus permanen!',
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
