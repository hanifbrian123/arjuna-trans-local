@extends('layouts.master')

@section('title', 'Kelola Kategori')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Kelola Kategori</h4>
            <div class="page-title-right">
                <a href="{{ route('admin.expenses.index') }}" class="btn btn-light">
                    <i class="ri-arrow-left-line"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Card for Add Category -->
<div class="row">
    <div class="col-lg-12">
        <div class="card border">
            <div class="card-header">
                <h5 class="card-title mb-0">Tambah Kategori Baru</h5>
            </div>

            <div class="card-body">

                <form action="{{ route('admin.expense_categories.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3">
                        <!-- Input Code -->
                        <div class="col-md-4">
                            <input type="text" 
                                name="code" 
                                class="form-control @error('code') is-invalid @enderror"
                                placeholder="Kode (Cth: B-11)"
                                value="{{ old('code') }}"
                                required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Name -->
                        <div class="col-md-5">
                            <input type="text" 
                                name="name" 
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Deskripsi Kategori"
                                value="{{ old('name') }}"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Color hidden input -->
                        <input type="hidden" name="pallete" id="selectedColor">

                        <!-- Submit -->
                        <div class="col-md-3 text-end">
                            <button class="btn btn-primary px-4">Simpan</button>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Pilih Tema Warna</label>
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach ($colors as $color)
                                <div class="color-selector rounded-circle border"
                                    data-color="{{ $color }}"
                                    style="width:32px;height:32px;background-color:{{ $color }};cursor:pointer;">
                                </div>
                            @endforeach
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- List Categories -->
<div class="row mt-4">
    <div class="col-lg-12">

        <div class="card border">
            <div class="card-body">

                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Kode</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $cat)
                        <tr>
                            <td>
                                <span class="rounded-circle d-inline-block" 
                                    style="width:14px;height:14px;background:{{ $cat->pallete }}"></span>
                            </td>
                            <td>
                                <a href="#" class="text-primary fw-semibold">{{ $cat->code }}</a>
                            </td>
                            <td>{{ $cat->name }}</td>
                            <td>
                                <div class="d-flex gap-3">
                                    <a href="javascript:void(0);"
                                        class="text-primary editBtn"
                                        data-id="{{ $cat->id }}"
                                        data-code="{{ $cat->code }}"
                                        data-name="{{ $cat->name }}"
                                        data-color="{{ $cat->pallete }}">
                                        <i class="ri-pencil-fill"></i>
                                    </a>

                                    <form action="{{ route('admin.expense_categories.destroy', $cat->id) }}" 
                                        method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-danger border-0 bg-transparent" title="Hapus">
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

<!-- Modal Edit Kategori -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editCategoryForm" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Kode</label>
                        <input type="text" name="code" id="editCodeInput" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="name" id="editNameInput" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilih Warna</label>
                        <input type="hidden" name="pallete" id="editColorInput">

                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($colors as $color)
                                <div class="edit-color circle border"
                                    data-color="{{ $color }}"
                                    style="width:30px;height:30px;border-radius:50%;background-color:{{ $color }};cursor:pointer;">
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>

            </div>
        </form>
    </div>
</div>


@endsection

@push('styles')
<style>
    .table-responsive {
    overflow-x: auto;
    scrollbar-width: thin;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    
    // COLOR PICKER
    const colorOptions = document.querySelectorAll('.color-selector');
    const hiddenColor = document.getElementById('selectedColor');

    colorOptions.forEach(el => {
        el.addEventListener('click', function() {
            colorOptions.forEach(c => c.style.outline = 'none');
            this.style.outline = '3px solid #5646ff';
            hiddenColor.value = this.dataset.color;
        });
    });

    
    // DELETE CONFIRMATION
    $(document).on('submit', '.delete-form', function(e) {
        e.preventDefault();
        let form = this;

        Swal.fire({
            title: 'Hapus Kategori?',
            text: "Data tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });


    // EDIT MODAL HANDLING
    const editModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));

    $(document).on('click', '.editBtn', function() {
        let id = $(this).data('id');
        let code = $(this).data('code');
        let name = $(this).data('name');
        let color = $(this).data('color');

        // Isi input modal
        $('#editCodeInput').val(code);
        $('#editNameInput').val(name);
        $('#editColorInput').val(color);

        // Set outline warna aktif
        $('.edit-color').css('outline', 'none');
        $(`.edit-color[data-color="${color}"]`).css('outline', '3px solid #5646ff');

        // Set action form
        let actionUrl = "{{ route('admin.expense_categories.update', ':id') }}";
        actionUrl = actionUrl.replace(':id', id);

        $('#editCategoryForm').attr('action', actionUrl);

        // Tampilkan modal
        editModal.show();
    });

    // EDIT COLOR PICK
    $('.edit-color').on('click', function() {
        $('.edit-color').css('outline', 'none');
        $(this).css('outline', '3px solid #5646ff');
        $('#editColorInput').val($(this).data('color'));
    });


});
</script>
@endpush
