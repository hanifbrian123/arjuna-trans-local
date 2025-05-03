@extends('layouts.master')

@section('title', 'Detail Armada')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Armada</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('driver.vehicles.index') }}">Armada</a></li>
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
                    <h5 class="card-title mb-0">Detail Armada</h5>
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
                                                @if (!empty($vehicle->facilities))
                                                    @foreach ($vehicle->facilities as $facility)
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
                                                @if ($vehicle->status == 'ready')
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
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('driver.vehicles.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
