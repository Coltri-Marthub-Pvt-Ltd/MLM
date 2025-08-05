import './bootstrap';
import 'bootstrap';
import '../css/admin.css';

// Admin Panel JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle functionality
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.admin-sidebar');
    const mainContent = document.querySelector('.admin-main-content');
    
    if (sidebarToggle && sidebar && mainContent) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
    }

    // Mobile sidebar overlay
    const sidebarOverlay = document.querySelector('.sidebar-overlay');
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            sidebarOverlay.remove();
        });
    }

    // Auto-dismiss alerts
    const alerts = document.querySelectorAll('.alert[data-auto-dismiss]');
    alerts.forEach(alert => {
        const delay = parseInt(alert.dataset.autoDismiss) || 5000;
        setTimeout(() => {
            alert.style.transition = 'opacity 0.3s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, delay);
    });

    // Form validation enhancement
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
            }
        });
    });

    // Table row actions
    const actionButtons = document.querySelectorAll('[data-confirm]');
    actionButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const message = this.dataset.confirm;
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });

    // Current page highlighting in navigation
    const currentUrl = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentUrl) {
            link.classList.add('active');
        }
    });
});
