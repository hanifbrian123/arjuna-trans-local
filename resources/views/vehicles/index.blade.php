@extends('layouts.master')

@section('title', 'Manajemen Kendaraan')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Manajemen Kendaraan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Kendaraan</li>
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
                        <h5 class="card-title mb-0 flex-grow-1">Daftar Kendaraan</h5>
                        <div class="flex-shrink-0">
                            <a href="{{ route('vehicles.create') }}" class="btn btn-primary">Tambah Kendaraan</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Foto</th>
                                    <th>Nama/Model</th>
                                    <th>Nomor Polisi</th>
                                    <th>Kapasitas</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vehicles as $vehicle)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ $vehicle->photo_url }}" alt="{{ $vehicle->name }}" class="rounded" height="48">
                                        </td>
                                        <td>{{ $vehicle->name }}</td>
                                        <td>{{ $vehicle->license_plate }}</td>
                                        <td>{{ $vehicle->capacity }} Kursi</td>
                                        <td>
                                            @if ($vehicle->status === 'available')
                                                <span class="badge bg-success">Tersedia</span>
                                            @elseif($vehicle->status === 'booked')
                                                <span class="badge bg-warning">Dipesan</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Tersedia</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a href="{{ route('vehicles.show', $vehicle->id) }}" class="dropdown-item">
                                                            <i class="ri-eye-fill align-bottom me-2 text-muted"></i> Detail
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="dropdown-item">
                                                            <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" class="delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="ri-delete-bin-fill align-bottom me-2 text-danger"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data kendaraan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="d-flex justify-content-end mt-3">
                        {{ $vehicles->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Handle delete confirmation
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data kendaraan akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endpush
