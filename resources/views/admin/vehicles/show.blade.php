@extends('layouts.master')

@section('title', 'Detail Armada')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Armada</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.vehicles.index') }}">Armada</a></li>
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
                        <h5 class="card-title mb-0 flex-grow-1">Detail Armada</h5>
                        <div>
                            <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="btn btn-primary">
                                <i class="ri-pencil-line"></i> Edit
                            </a>
                            <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" class="d-inline delete-form">
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
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="ps-0" width="25%">Nama Armada</th>
                                            <td>{{ $vehicle->name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Tipe</th>
                                            <td>{{ $vehicle->type }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Kapasitas</th>
                                            <td>{{ $vehicle->capacity }} Seat</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Fasilitas</th>
                                            <td>
                                                @if(!empty($vehicle->facilities))
                                                    @foreach($vehicle->facilities as $facility)
                                                        <span class="badge bg-info me-1">{{ $facility }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Status</th>
                                            <td>
                                                @if($vehicle->status == 'ready')
                                                    <span class="badge bg-success">Siap</span>
                                                @elseif($vehicle->status == 'maintenance')
                                                    <span class="badge bg-warning">Maintenance</span>
                                                @elseif($vehicle->status == 'booked')
                                                    <span class="badge bg-danger">Terpesan</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="text-center">
                                @if($vehicle->photo)
                                    <img src="{{ asset($vehicle->photo) }}" alt="{{ $vehicle->name }}" class="img-fluid rounded" style="max-height: 200px;">
                                @else
                                    <div class="border rounded p-3 text-center">
                                        <i class="ri-image-line display-4 text-muted"></i>
                                        <p class="mt-2">Belum ada foto</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">Kembali</a>
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
