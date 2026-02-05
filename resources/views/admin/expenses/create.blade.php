@extends('layouts.master')

@section('title', 'Tambah Pengeluaran')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Pengeluaran</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.expenses.index') }}">Pengeluaran</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Card -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-header">
                    <h5 class="card-title mb-0">Form Tambah Pengeluaran</h5>
                    <div class="mt-3">
                        <a href="{{ route('admin.expense_categories.index') }}" class="btn btn-outline-secondary" title="Klik Untuk Kelola Kategori">
                            <i class="mdi mdi-cog-outline align-bottom me-1"></i> Kelola Kategori
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.expenses.store') }}" method="POST">
                        @csrf

                        <!-- TANGGAL -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label class="form-label">Tanggal</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="date"
                                    name="date"
                                    class="form-control @error('date') is-invalid @enderror"
                                    value="{{ old('date', date('Y-m-d')) }}"
                                    required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        
                        <!-- KATEGORI -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label class="form-label">Kategori</label>
                            </div>
                            <div class="col-lg-9">
                                <select name="expense_category_id"
                                        class="form-select @error('expense_category_id') is-invalid @enderror"
                                        required>
                                        <option value="" disabled selected>Pilih Kategori...</option>
                                    @foreach ($expense_categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('expense_category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->code }} — {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('expense_category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>
                        
                        <!-- NOMINAL -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label class="form-label">Nominal (Rp)</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text"
                                    id="nominal"
                                    name="nominal"
                                    class="form-control @error('nominal') is-invalid @enderror"
                                    placeholder="Rp - Masukkan nominal"
                                    value="{{ old('nominal') }}"
                                    min="0"
                                    required>
                                @error('nominal')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- ARMADA -->
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label class="form-label">Armada</label>
                            </div>
                            <div class="col-lg-9">
                                <select name="vehicle_id[]"
                                    class="form-select @error('vehicle_id') is-invalid @enderror"
                                    data-choices data-choices-removeItem
                                    multiple
                                    size="5"
                                    required>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}"
                                            {{ in_array($vehicle->id, old('vehicle_id', [])) ? 'selected' : '' }}>
                                            {{ $vehicle->name }} ({{ $vehicle->type }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('vehicle_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- KETERANGAN -->
                        <div class="row mb-4">
                            <div class="col-lg-3">
                                <label class="form-label">Keterangan</label>
                            </div>
                            <div class="col-lg-9">
                                <textarea name="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        rows="3"
                                        placeholder="Masukkan detail transaksi...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- BUTTONS -->
                        <div class="text-end">
                            <a href="{{ route('admin.expenses.index') }}"
                            class="btn btn-secondary"
                            title="Klik untuk kembali">
                                Kembali
                            </a>

                            <button type="submit" class="btn btn-primary" title="Klik untuk simpan">
                                Simpan Transaksi
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // FORMAT RUPIAH
    const nominalInput = document.querySelector('#nominal');

    function formatRupiah(angka, prefix = 'Rp ') {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;

        return rupiah;
    }

    function parseRupiah(value) {
        return parseInt(value.replace(/[^0-9]/g, ''));
    }

    function updateNominalFormat() {
        nominalInput.value = formatRupiah(parseRupiah(nominalInput.value).toString());
    }

    // Listener untuk input nominal
    nominalInput.addEventListener('keyup', updateNominalFormat);
    nominalInput.addEventListener('change', updateNominalFormat);

    // Trigger saat load apabila ada old value
    updateNominalFormat();

});
</script>
@endpush

