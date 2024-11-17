document.addEventListener('DOMContentLoaded', function() {
    const toasts = document.querySelectorAll('.toast-message');
    
    toasts.forEach(toast => {
        // 設定自動關閉計時器
        setTimeout(() => {
            hideToast(toast);
        }, 3000); // 3秒後自動關閉
    });
});

function hideToast(toast) {
    toast.classList.add('hiding');
    setTimeout(() => {
        toast.remove();
    }, 500);
} 