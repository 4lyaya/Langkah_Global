import './bootstrap'
import './darkmode'
import './alpine'
import { initInfiniteScroll } from './infinite-scroll'

// Initialize components
document.addEventListener('DOMContentLoaded', function () {
    // Initialize any other JavaScript components here
})

// SweetAlert notifications
window.showNotification = function (type, message) {
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
    })

    Toast.fire({
        icon: type,
        title: message
    })
}

// Handle flash messages
document.addEventListener('DOMContentLoaded', function () {
    const successMessage = document.querySelector('[x-data*="success"]')
    const errorMessage = document.querySelector('[x-data*="error"]')

    if (successMessage) {
        showNotification('success', successMessage.textContent)
    }

    if (errorMessage) {
        showNotification('error', errorMessage.textContent)
    }
})