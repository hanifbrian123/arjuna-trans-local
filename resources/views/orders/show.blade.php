@extends('layouts.master')

@section('title', 'Detail Order')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Order</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ auth()->user()->hasRole('admin') ? route('orders.admin.index') : route('orders.index') }}">Order</a></li>
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
                    <h5 class="card-title mb-0">Detail Order #{{ $order->id }}</h5>
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
                                @if($order->status == 'waiting')
                                    <span class="badge bg-warning fs-5">Menunggu</span>
                                @elseif($order->status == 'approved')
                                    <span class="badge bg-success fs-5">Disetujui</span>
                                @elseif($order->status == 'canceled')
                                    <span class="badge bg-danger fs-5">Dibatalkan</span>
                                @else
                                    <span class="badge bg-secondary fs-5">{{ $order->status }}</span>
                                @endif
                            </div>
                            
                            @if(auth()->user()->hasRole('driver') && $order->status == 'waiting')
                                <form action="{{ route('orders.accept', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success">Terima Order</button>
                                </form>
                            @endif
                            
                            @if(auth()->user()->hasRole('admin'))
                                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary">Edit Order</a>
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
                                            <td>{{ $order->route }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="mb-3">Informasi Kendaraan</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="30%">Jumlah Kendaraan</th>
                                            <td>{{ $order->vehicle_count }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tipe Kendaraan</th>
                                            <td>{{ $order->vehicle_type }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="30%">Nama Driver</th>
                                            <td>{{ $order->driver_name }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="mb-3">Informasi Pembayaran</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="30%">Harga Sewa</th>
                                            <td>{{ number_format($order->rental_price, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Uang Muka</th>
                                            <td>{{ $order->down_payment ? number_format($order->down_payment, 0, ',', '.') : '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="30%">Sisa Biaya</th>
                                            <td>{{ $order->remaining_cost ? number_format($order->remaining_cost, 0, ',', '.') : '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($order->additional_notes)
                    <hr>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="mb-3">Catatan Tambahan</h5>
                            <p>{{ $order->additional_notes }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="text-end mt-4">
                        <a href="{{ auth()->user()->hasRole('admin') ? route('orders.admin.index') : route('orders.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
