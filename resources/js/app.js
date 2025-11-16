import './bootstrap';
import * as bootstrap from 'bootstrap/dist/js/bootstrap.bundle.min.js';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

// Make bootstrap and toastr available globally
window.bootstrap = bootstrap;
window.toastr = toastr;

// Configure Toastr
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

// Auto-hide alerts
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Show toastr notifications from session flash messages
    const successMessage = document.querySelector('meta[name="flash-success"]');
    const errorMessage = document.querySelector('meta[name="flash-error"]');
    const infoMessage = document.querySelector('meta[name="flash-info"]');
    const warningMessage = document.querySelector('meta[name="flash-warning"]');

    if (successMessage) {
        toastr.success(successMessage.content);
    }
    if (errorMessage) {
        toastr.error(errorMessage.content);
    }
    if (infoMessage) {
        toastr.info(infoMessage.content);
    }
    if (warningMessage) {
        toastr.warning(warningMessage.content);
    }
});

// Confirm delete actions
document.addEventListener('click', function(e) {
    if (e.target.matches('[data-confirm]')) {
        if (!confirm(e.target.dataset.confirm)) {
            e.preventDefault();
        }
    }
});
