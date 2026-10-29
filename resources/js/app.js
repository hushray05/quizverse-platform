import './bootstrap';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';
import '@fortawesome/fontawesome-free/js/all.min.js';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

window.Swal = Swal;
window.Chart = Chart;

// Global Theme toggle
window.toggleTheme = function() {
    const isDark = document.documentElement.classList.toggle('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
};

// Global Toast notification helper
window.notify = function(type, message, title = '') {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: type, // 'success', 'error', 'warning', 'info'
        title: title || message,
        text: title ? message : undefined,
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
    });
};

// Global confirm dialog replacement
document.addEventListener('click', function(e) {
    const target = e.target.closest('[data-confirm]');
    if (!target) return;

    e.preventDefault();
    const message = target.getAttribute('data-confirm') || 'Are you sure you want to proceed?';
    const form = target.closest('form');

    const isDark = document.documentElement.classList.contains('dark');

    Swal.fire({
        title: 'Confirmation',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: isDark ? '#3B82F6' : '#2563EB',
        cancelButtonColor: isDark ? '#334155' : '#64748B',
        confirmButtonText: 'Yes, proceed',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            if (form) {
                form.submit();
            } else if (target.tagName === 'A' && target.href) {
                window.location.href = target.href;
            }
        }
    });
});
