@extends('layouts.master')

@section('title', 'Detail Order')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Order</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('driver.orders.index') }}">Order</a></li>
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
                        <h5 class="card-title mb-0 flex-grow-1">Detail Order {{ $order->order_num }}</h5>
                        <div>
                            @if ($order->user_id == auth()->id() || ($order->status == 'waiting' && !$order->driver_id))
                                <a href="{{ route('driver.orders.edit', $order->id) }}" class="btn btn-primary">
                                    <i class="ri-edit-line"></i> Edit Order
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="mb-3">Informasi Pelanggan</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Nama</th>
                                    <td>{{ $order->name }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor Telepon</th>
                                    <td>{{ $order->phone_number }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $order->address }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-3">Status Order</h5>
                            <div class="mb-3">
                                @if ($order->status == 'waiting')
                                    <span class="badge bg-warning fs-5">Menunggu</span>
                                @elseif($order->status == 'approved')
                                    <span class="badge bg-success fs-5">Disetujui</span>
                                @elseif($order->status == 'canceled')
                                    <span class="badge bg-danger fs-5">Dibatalkan</span>
                                @elseif($order->status == 'completed')
                                    <span class="badge bg-info fs-5">Selesai</span>
                                @else
                                    <span class="badge bg-secondary fs-5">{{ $order->status }}</span>
                                @endif
                            </div>

                            @if ($order->driver_id && $order->driver_id == auth()->user()->driver->id)
                                <div class="alert alert-success mt-3">
                                    <i class="ri-user-follow-line me-2"></i> Anda ditugaskan untuk order ini
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="mb-3">Informasi Perjalanan</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="30%">Tanggal Mulai</th>
                                            <td>{{ $order->start_date->format('d M Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Selesai</th>
                                            <td>{{ $order->end_date->format('d M Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat Penjemputan</th>
                                            <td>{{ $order->pickup_address }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="30%">Tujuan</th>
                                            <td>{{ $order->destination }}</td>
                                        </tr>
                                        <tr>
                                            <th>Rute</th>
                                            <td>{{ $order->route ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jumlah Penumpang</th>
                                            <td>{{ $order->passenger_count }} orang</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="mb-3">Informasi Armada</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="30%">Tipe Armada</th>
                                            <td>{{ $order->vehicle_type }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($order->additional_notes)
                        <hr>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="mb-3">Catatan Tambahan</h5>
                                <p>{{ $order->additional_notes }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="text-end mt-4">
                        <a href="{{ route('driver.orders.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
