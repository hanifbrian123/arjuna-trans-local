@extends('layouts.master')

@section('title', 'Detail Driver')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Driver</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.drivers.index') }}">Driver</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Detail Driver</h5>
                        <div>
                            <a href="{{ route('admin.drivers.edit', $driver->id) }}" class="btn btn-primary">
                                <i class="ri-pencil-line"></i> Edit
                            </a>
                            <form action="{{ route('admin.drivers.destroy', $driver->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="ri-delete-bin-line"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Informasi Akun -->
                            <h5 class="mb-3">Informasi Akun</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="ps-0" width="25%">Nama</th>
                                            <td>{{ $driver->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Email</th>
                                            <td>{{ $driver->user->email }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Informasi Driver -->
                            <h5 class="mb-3 mt-4">Informasi Driver</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="ps-0" width="25%">Alamat</th>
                                            <td>{{ $driver->address }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Nomor Telepon</th>
                                            <td>{{ $driver->phone_number }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Tipe SIM</th>
                                            <td>SIM {{ $driver->license_type }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Status</th>
                                            <td>
                                                @if($driver->status == 'active')
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Tidak Aktif</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Catatan</th>
                                            <td>{{ $driver->notes ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Event delegation untuk form delete
        document.querySelector('.delete-form')?.addEventListener('submit', function(e) {
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
