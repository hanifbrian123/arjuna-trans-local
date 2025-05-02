/**
 * Global SweetAlert utility functions
 */

// Toast notification
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

// Success toast
function showSuccessToast(message) {
    Toast.fire({
        icon: 'success',
        title: message
    });
}

// Error toast
function showErrorToast(message) {
    Toast.fire({
        icon: 'error',
        title: message
    });
}

// Warning toast
function showWarningToast(message) {
    Toast.fire({
        icon: 'warning',
        title: message
    });
}

// Info toast
function showInfoToast(message) {
    Toast.fire({
        icon: 'info',
        title: message
    });
}

// Confirmation dialog
function showConfirmDialog(title, text, confirmButtonText = 'Ya', cancelButtonText = 'Batal') {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
        reverseButtons: true
    });
}

// Success modal
function showSuccessModal(title, text) {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'success'
    });
}

// Error modal
function showErrorModal(title, text) {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'error'
    });
}
