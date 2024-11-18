document.addEventListener('DOMContentLoaded', function() {
    const toasts = document.querySelectorAll('.toast-message');
    
    toasts.forEach(toast => {
        setTimeout(() => {
            hideToast(toast);
        }, 3000);
    });
});

function hideToast(toast) {
    toast.classList.add('hiding');
    setTimeout(() => {
        toast.remove();
    }, 500);
}

window.showToast = function(message, type = 'success') {
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = `toast-message toast-${type}`;
    toast.setAttribute('role', 'alert');
    toast.textContent = message;

    container.appendChild(toast);

    setTimeout(() => {
        hideToast(toast);
    }, 3000);
} 