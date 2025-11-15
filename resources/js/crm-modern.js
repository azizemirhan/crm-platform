/**
 * CRM Modern UI Enhancements
 * Modern JavaScript functionality for Lead and Contact management
 */

document.addEventListener('DOMContentLoaded', function() {

    // Initialize Bootstrap Tooltips
    initializeTooltips();

    // Initialize smooth scrolling
    initializeSmoothScroll();

    // Add animation on scroll
    initializeScrollAnimations();

    // Initialize form validations
    initializeFormValidations();
});

/**
 * Initialize Bootstrap Tooltips
 */
function initializeTooltips() {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
}

/**
 * Initialize smooth scrolling for anchor links
 */
function initializeSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId !== '#') {
                e.preventDefault();
                const target = document.querySelector(targetId);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
}

/**
 * Add fade-in animation on scroll
 */
function initializeScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-visible');
            }
        });
    }, observerOptions);

    // Observe all elements with fade-in class
    document.querySelectorAll('.fade-in-on-scroll').forEach(el => {
        observer.observe(el);
    });
}

/**
 * Enhanced form validations
 */
function initializeFormValidations() {
    const forms = document.querySelectorAll('.needs-validation');

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Email validation enhancement
    const emailInputs = document.querySelectorAll('input[type="email"]');
    emailInputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateEmail(this);
        });
    });

    // Phone number formatting
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            formatPhoneNumber(this);
        });
    });
}

/**
 * Validate email format
 */
function validateEmail(input) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (input.value && !emailRegex.test(input.value)) {
        input.classList.add('is-invalid');
        showFieldError(input, 'Geçerli bir e-posta adresi girin');
    } else {
        input.classList.remove('is-invalid');
        hideFieldError(input);
    }
}

/**
 * Format phone number as user types
 */
function formatPhoneNumber(input) {
    let value = input.value.replace(/\D/g, '');

    if (value.startsWith('90')) {
        value = value.substring(2);
    }

    if (value.length > 0) {
        let formatted = '+90';
        if (value.length > 0) formatted += ' (' + value.substring(0, 3);
        if (value.length > 3) formatted += ') ' + value.substring(3, 6);
        if (value.length > 6) formatted += ' ' + value.substring(6, 8);
        if (value.length > 8) formatted += ' ' + value.substring(8, 10);

        input.value = formatted;
    }
}

/**
 * Show field error message
 */
function showFieldError(input, message) {
    let feedback = input.nextElementSibling;
    if (!feedback || !feedback.classList.contains('invalid-feedback')) {
        feedback = document.createElement('div');
        feedback.className = 'invalid-feedback d-block';
        input.parentNode.appendChild(feedback);
    }
    feedback.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>' + message;
}

/**
 * Hide field error message
 */
function hideFieldError(input) {
    const feedback = input.nextElementSibling;
    if (feedback && feedback.classList.contains('invalid-feedback')) {
        feedback.remove();
    }
}

/**
 * Auto-dismiss alerts after 5 seconds
 */
function autoDismissAlerts() {
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
}

// Initialize auto-dismiss for alerts
document.addEventListener('DOMContentLoaded', autoDismissAlerts);

/**
 * Confirm delete actions
 */
document.addEventListener('click', function(e) {
    if (e.target.closest('[data-confirm-delete]')) {
        const button = e.target.closest('[data-confirm-delete]');
        const message = button.getAttribute('data-confirm-delete') ||
                       'Bu işlemi gerçekleştirmek istediğinizden emin misiniz?';

        if (!confirm(message)) {
            e.preventDefault();
            e.stopPropagation();
            return false;
        }
    }
});

/**
 * Loading state for buttons
 */
function setButtonLoading(button, loading = true) {
    if (loading) {
        button.disabled = true;
        button.dataset.originalText = button.innerHTML;
        button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Yükleniyor...';
    } else {
        button.disabled = false;
        button.innerHTML = button.dataset.originalText || button.innerHTML;
    }
}

/**
 * Export functions for global use
 */
window.CRM = {
    setButtonLoading,
    validateEmail,
    formatPhoneNumber,
    showFieldError,
    hideFieldError
};
