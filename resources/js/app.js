import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// Auto-hide alerts
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});

// Confirm delete actions
document.addEventListener('click', function(e) {
    if (e.target.matches('[data-confirm]')) {
        if (!confirm(e.target.dataset.confirm)) {
            e.preventDefault();
        }
    }
});
