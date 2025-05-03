@extends('layouts.master')

@section('title', 'Manajemen Driver')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Daftar Driver</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Daftar Driver</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Daftar Driver</h5>
                    <div class="mt-2">
                        <a href="{{ route('admin.drivers.create') }}" class="btn btn-primary">
                            <i class="ri-add-line align-bottom me-1"></i> Tambah Driver
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <table id="driversTable" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Driver</th>
                                <th>Alamat</th>
                                <th>Nomor Whatsapp</th>
                                <th>Tipe SIM</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($drivers as $index => $driver)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $driver->user->name }}</td>
                                    <td>{{ $driver->address }}</td>
                                    <td>{{ $driver->phone_number }}</td>
                                    <td>
                                        @if (!empty($driver->license_type))
                                            @php
                                                $licenseTypes = is_array($driver->license_type) ? $driver->license_type : [$driver->license_type];
                                            @endphp
                                            @foreach ($licenseTypes as $licenseType)
                                                <span class="badge bg-info me-1">SIM {{ $licenseType }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $driver->notes ?? '-' }}</td>
                                    <td>
                                        @if ($driver->status == 'active')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.drivers.edit', $driver->id) }}" class="btn btn-sm btn-primary">
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
            $('#driversTable').DataTable({
                responsive: true,
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
