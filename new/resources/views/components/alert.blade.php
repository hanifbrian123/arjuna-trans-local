@props(['type' => 'success', 'message' => ''])

@if(session('success') || session('error') || session('warning') || session('info') || $message)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success') || ($type == 'success' && $message))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') ?: $message }}'
            });
        @endif

        @if(session('error') || ($type == 'error' && $message))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') ?: $message }}'
            });
        @endif

        @if(session('warning') || ($type == 'warning' && $message))
            Toast.fire({
                icon: 'warning',
                title: '{{ session('warning') ?: $message }}'
            });
        @endif

        @if(session('info') || ($type == 'info' && $message))
            Toast.fire({
                icon: 'info',
                title: '{{ session('info') ?: $message }}'
            });
        @endif
    });
</script>
@endif
