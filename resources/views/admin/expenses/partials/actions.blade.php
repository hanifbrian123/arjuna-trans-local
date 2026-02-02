<div class="d-flex gap-2">
    <a href="{{ route('admin.expenses.edit', $row->id) }}" 
        class="btn btn-sm btn-primary">
        <i class="ri-pencil-fill"></i>
    </a>

    <form action="{{ route('admin.expenses.destroy', $row->id) }}" method="POST" class="delete-form d-inline">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger">
            <i class="ri-delete-bin-fill"></i>
        </button>
    </form>
</div>
