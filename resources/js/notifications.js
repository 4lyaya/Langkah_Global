import Swal from 'sweetalert2';

// Listen for new notifications
Echo.private(`user.${userId}`)
    .notification((notification) => {
        Swal.fire({
            title: 'New Notification',
            text: notification.message,
            icon: 'info',
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000
        });
    });